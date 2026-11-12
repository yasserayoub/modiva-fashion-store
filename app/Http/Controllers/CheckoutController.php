<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::with([
            'product',
            'inventory',
        ])
        ->where('isactive', true)
        ->whereHas('product', function ($query) {
            $query->where('isactive', true);
        })
        ->findOrFail($validated['variant_id']);

        $inventory = $variant->inventory;

        $availableStock = $inventory
            ? max(0, $inventory->quantity - $inventory->reservedquantity)
            : 0;

        $cart = session()->get('cart', []);

        $variantId = $variant->id;

        $currentQuantity = $cart[$variantId]['quantity'] ?? 0;
        $newQuantity = $currentQuantity + $validated['quantity'];

        if ($newQuantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.',
            ], 422);
        }

        $cart[$variantId] = [
            'variant_id' => $variantId,
            'quantity' => $newQuantity,
        ];

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart.',
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }
    public function applyCoupon(Request $request)
{
    $request->validate([
        'code' => ['required', 'string', 'max:60'],
    ]);

    $cart = session('cart', []);

    if (empty($cart)) {
        return response()->json([
            'success' => false,
            'message' => 'Your cart is empty.',
        ], 422);
    }

    $coupon = Coupon::whereRaw(
        'LOWER(code) = ?',
        [strtolower(trim($request->code))]
    )->first();

    if (!$coupon || !$coupon->isactive) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid or inactive promo code.',
        ], 422);
    }

    if ($coupon->startsat && now()->lt($coupon->startsat)) {
        return response()->json([
            'success' => false,
            'message' => 'This promo code is not available yet.',
        ], 422);
    }

    if ($coupon->expiresat && now()->gt($coupon->expiresat)) {
        return response()->json([
            'success' => false,
            'message' => 'This promo code has expired.',
        ], 422);
    }

    if ($coupon->usagelimit !== null &&
        $coupon->usages()->count() >= $coupon->usagelimit) {
        return response()->json([
            'success' => false,
            'message' => 'This promo code has reached its usage limit.',
        ], 422);
    }

    // Calculate the cart subtotal using database prices.
    $subtotal = 0;

    foreach ($cart as $item) {
        $variant = ProductVariant::with('product')
            ->find($item['variant_id']);

        if (!$variant || !$variant->product) {
            return response()->json([
                'success' => false,
                'message' => 'A product in your cart is no longer available.',
            ], 422);
        }

        $product = $variant->product;

        $price = $variant->priceoverride !== null
            ? (float) $variant->priceoverride
            : (float) ($product->saleprice ?? $product->baseprice);

        $subtotal += $price * (int) $item['quantity'];
    }

    if ($subtotal < (float) $coupon->minimumorderamount) {
        return response()->json([
            'success' => false,
            'message' => 'Minimum order amount for this code is $' .
                number_format((float) $coupon->minimumorderamount, 2) . '.',
        ], 422);
    }

    // Calculate the discount.
    if ($coupon->discounttype === 'percentage') {
        $discount = $subtotal * ((float) $coupon->discountvalue / 100);

        if ($coupon->maximumdiscount !== null) {
            $discount = min(
                $discount,
                (float) $coupon->maximumdiscount
            );
        }
    } else {
        $discount = (float) $coupon->discountvalue;
    }

    $discount = min($discount, $subtotal);

    // Save the validated coupon in the session.
    session([
        'applied_coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => round($discount, 2),
        ],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Promo code applied successfully!',
        'code' => $coupon->code,
        'discount' => round($discount, 2),
        'subtotal' => round($subtotal, 2),
        'total' => round($subtotal - $discount, 2),
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'firstname' => 'required|string|max:100',
        'lastname' => 'required|string|max:100',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:30',
        'streetaddress' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'postalcode' => 'nullable|string|max:30',
        'country' => 'required|string|max:100',
        'deliverymethod' => 'required|in:standard,express',
        'paymentmethod' => 'required|in:cash_on_delivery',
    ]);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->back()->withErrors([
            'cart' => 'Your cart is empty.',
        ]);
    }

    try {
        $order = DB::transaction(function () use ($cart, $validated) {

            $subtotal = 0;
            $orderItems = [];

            foreach ($cart as $cartItem) {
                $variant = ProductVariant::with([
                    'product',
                    'size',
                    'color',
                ])
                ->where('isactive', true)
                ->whereHas('product', function ($query) {
                    $query->where('isactive', true);
                })
                ->findOrFail($cartItem['variant_id']);

                $inventory = Inventory::where(
                    'productvariantid',
                    $variant->id
                )->lockForUpdate()->first();

                $availableStock = $inventory
                    ? max(0, $inventory->quantity - $inventory->reservedquantity)
                    : 0;

                $quantity = (int) $cartItem['quantity'];

                if (!$inventory || $quantity > $availableStock) {
                    throw new \Exception(
                        'Insufficient stock for ' . $variant->product->name
                    );
                }

                $unitPrice = $variant->priceoverride
                    ?? $variant->product->saleprice
                    ?? $variant->product->baseprice;

                $unitPrice = (float) $unitPrice;
                $lineSubtotal = $unitPrice * $quantity;

                $subtotal += $lineSubtotal;

                $orderItems[] = [
                    'variant' => $variant,
                    'quantity' => $quantity,
                    'unitprice' => $unitPrice,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $shippingFee = $validated['deliverymethod'] === 'express'
                ? 9
                : 0;

            $total = $subtotal + $shippingFee;

            $addressSnapshot = [
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'streetaddress' => $validated['streetaddress'],
                'city' => $validated['city'],
                'postalcode' => $validated['postalcode'] ?? null,
                'country' => $validated['country'],
            ];

            $order = Order::create([
                'userid' => null,
                'addressid' => null,
                'couponid' => null,
                'ordernumber' => 'YF-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'discountamount' => 0,
                'shippingfee' => $shippingFee,
                'totalamount' => $total,
                'paymentstatus' => 'pending',
                'orderstatus' => 'pending',
                'shippingaddresssnapshot' => $addressSnapshot,
                'notes' => 'Delivery: ' . $validated['deliverymethod'],
            ]);

            foreach ($orderItems as $item) {
                $variant = $item['variant'];

                OrderItem::create([
                    'orderid' => $order->id,
                    'productvariantid' => $variant->id,
                    'productname' => $variant->product->name,
                    'sku' => $variant->sku,
                    'sizename' => $variant->size->name ?? null,
                    'colorname' => $variant->color->name ?? null,
                    'unitprice' => $item['unitprice'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                Inventory::where('productvariantid', $variant->id)
                    ->increment('reservedquantity', $item['quantity']);
            }

            Payment::create([
                'orderid' => $order->id,
                'paymentmethod' => 'cash_on_delivery',
                'transactionreference' => null,
                'amount' => $total,
                'status' => 'pending',
                'paidat' => null,
            ]);

            return $order;
        });

        session()->forget('cart');

        return redirect()->back()->with(
            'order_success',
            'Your order ' . $order->ordernumber . ' was placed successfully!'
        );

    } catch (\Throwable $e) {
        return redirect()->back()->withErrors([
            'checkout' => $e->getMessage(),
        ]);
    }
}


public function updateCart(Request $request)
{
    $validated = $request->validate([
        'variant_id' => 'required|integer',
        'quantity' => 'required|integer|min:1',
    ]);

    $variant = ProductVariant::with('product', 'inventory')
        ->where('isactive', true)
        ->whereHas('product', function ($query) {
            $query->where('isactive', true);
        })
        ->findOrFail($validated['variant_id']);

    $inventory = $variant->inventory;

    $availableStock = $inventory
        ? max(0, $inventory->quantity - $inventory->reservedquantity)
        : 0;

    if ($validated['quantity'] > $availableStock) {
        return response()->json([
            'success' => false,
            'message' => 'Not enough stock available.',
        ], 422);
    }

    $cart = session()->get('cart', []);
    $variantId = $variant->id;

    if (!isset($cart[$variantId])) {
        return response()->json([
            'success' => false,
            'message' => 'This item is not in your cart.',
        ], 404);
    }

    $cart[$variantId]['quantity'] = $validated['quantity'];

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'message' => 'Cart updated successfully.',
        'cart_count' => array_sum(array_column($cart, 'quantity')),
    ]);
}

public function removeFromCart(Request $request)
{
    $validated = $request->validate([
        'variant_id' => 'required|integer',
    ]);

    $cart = session()->get('cart', []);

    $variantId = $validated['variant_id'];

    if (!isset($cart[$variantId])) {
        return response()->json([
            'success' => false,
            'message' => 'This item is not in your cart.',
        ], 404);
    }

    unset($cart[$variantId]);

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'message' => 'Product removed from cart.',
        'cart_count' => array_sum(array_column($cart, 'quantity')),
    ]);
}
public function getCart()
{
    $cart = session()->get('cart', []);

    return response()->json([
        'success' => true,
        'items' => array_values($cart),
        'cart_count' => array_sum(
            array_column($cart, 'quantity')
        ),
    ]);
}

}
