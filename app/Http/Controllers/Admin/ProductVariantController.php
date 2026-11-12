<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    // Display variants belonging to a product
    public function index(Product $product)
    {
        $product->load([
            'variants.size',
            'variants.color',
            'variants.inventory'
        ]);

        return view('admin.variants.index', compact('product'));
    }

    // Show the form to create variants
    public function create(Product $product)
    {
        $sizes = Size::orderBy('sortorder')->get();
        $colors = Color::orderBy('name')->get();

        return view('admin.variants.create', compact(
            'product',
            'sizes',
            'colors'
        ));
    }

    // Store multiple size and color combinations
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sizeids' => 'required|array|min:1',
            'sizeids.*' => [
                'required',
                'distinct',
                'exists:sizes,id'
            ],

            'colorids' => 'required|array|min:1',
            'colorids.*' => [
                'required',
                'distinct',
                'exists:colors,id'
            ],

            'priceoverride' => 'nullable|numeric|min:0',
            'isactive' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated, $product) {

            foreach ($validated['sizeids'] as $sizeid) {

                foreach ($validated['colorids'] as $colorid) {

                    // Check whether this combination already exists
                    $exists = ProductVariant::where('productid', $product->id)
                        ->where('sizeid', $sizeid)
                        ->where('colorid', $colorid)
                        ->exists();

                    if ($exists) {
                        throw ValidationException::withMessages([
                            'sizeids' => 'One or more selected size and color combinations already exist.'
                        ]);
                    }

                    // Generate a unique SKU
                    $sku = 'PRD-' . $product->id
                        . '-SZ' . $sizeid
                        . '-CL' . $colorid;

                    ProductVariant::create([
                        'productid' => $product->id,
                        'sizeid' => $sizeid,
                        'colorid' => $colorid,
                        'sku' => $sku,
                        'priceoverride' => $validated['priceoverride'] ?? null,
                        'isactive' => $validated['isactive'],
                    ]);

                    $variant = ProductVariant::latest('id')->first();

                    $variant->inventory()->create([
                        'quantity' => $validated['quantity'],
                        'reservedquantity' => 0,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.variants.index', $product->id)
            ->with('success', 'Product variants created successfully.');
    }

    // Show the edit form
    public function edit(Product $product, ProductVariant $variant)
    {
        abort_unless($variant->productid == $product->id, 404);

        $variant->load('inventory');

        $sizes = Size::orderBy('sortorder')->get();
        $colors = Color::orderBy('name')->get();

        return view('admin.variants.edit', compact(
            'product',
            'variant',
            'sizes',
            'colors'
        ));
    }

    // Update variant and inventory
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        abort_unless($variant->productid == $product->id, 404);

        $validated = $request->validate([
            'sizeid' => [
                'required',
                'exists:sizes,id',
                Rule::unique('productvariants', 'sizeid')
                    ->where('productid', $product->id)
                    ->where('colorid', $request->colorid)
                    ->ignore($variant->id),
            ],

            'colorid' => 'required|exists:colors,id',

            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('productvariants', 'sku')->ignore($variant->id),
            ],

            'priceoverride' => 'nullable|numeric|min:0',
            'isactive' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($validated, $variant) {

            $variant->update([
                'sizeid' => $validated['sizeid'],
                'colorid' => $validated['colorid'],
                'sku' => $validated['sku'],
                'priceoverride' => $validated['priceoverride'] ?? null,
                'isactive' => $validated['isactive'],
            ]);

            $variant->inventory()->updateOrCreate(
                ['productvariantid' => $variant->id],
                ['quantity' => $validated['quantity']]
            );
        });

        return redirect()
            ->route('admin.variants.index', $product->id)
            ->with('success', 'Product variant updated successfully.');
    }

    // Delete a variant
    public function destroy(Product $product, ProductVariant $variant)
    {
        abort_unless($variant->productid == $product->id, 404);

        DB::transaction(function () use ($variant) {
            $variant->inventory()->delete();
            $variant->delete();
        });

        return redirect()
            ->route('admin.variants.index', $product->id)
            ->with('success', 'Product variant deleted successfully.');
    }
}
