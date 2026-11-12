<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')
            ->withCount('orderItems');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ordernumber', 'ILIKE', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('firstname', 'ILIKE', "%{$search}%")
                            ->orWhere('lastname', 'ILIKE', "%{$search}%")
                            ->orWhere('email', 'ILIKE', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('orderstatus', $request->status);
        }

        $orders = $query->orderBy('createdat', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load([
            'user',
            'orderItems',
            'address',
            'coupon',
            'payment'
        ]);

        return view('admin.orders.show', compact('order'));
    }
    public function updateStatus(Request $request, Order $order)
{
    $validated = $request->validate([
        'orderstatus' => [
            'required',
            'in:pending,processing,shipped,delivered,cancelled',
        ],
    ]);

    $order->update([
        'orderstatus' => $validated['orderstatus'],
    ]);

    return redirect()
        ->route('admin.orders.show', $order->id)
        ->with('success', 'Order status updated successfully.');
}
public function markAsPaid(Order $order)
{
    DB::transaction(function () use ($order) {
        $order->update([
            'paymentstatus' => 'paid',
        ]);

        $payment = $order->payment;

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'paidat' => now(),
            ]);
        }
    });

    return redirect()
        ->route('admin.orders.show', $order->id)
        ->with('success', 'Payment marked as paid successfully.');
}
}
