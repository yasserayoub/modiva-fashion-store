<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with([
            'productVariant.product',
            'productVariant.size',
            'productVariant.color'
        ]);

        // Search by product name or SKU
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('productVariant', function ($variantQuery) use ($search) {
                $variantQuery->where('sku', 'ILIKE', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'ILIKE', "%{$search}%");
                    });
            });
        }

        // Filter low-stock inventory
        if ($request->stock === 'low') {
            $query->whereRaw('(quantity - reservedquantity) <= 5');
        }

        // Filter out-of-stock inventory
        if ($request->stock === 'out') {
            $query->whereRaw('(quantity - reservedquantity) <= 0');
        }

        $inventory = $query
            ->orderBy('updatedat', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalVariants = Inventory::count();

        $lowStockCount = Inventory::whereRaw(
            '(quantity - reservedquantity) > 0 AND (quantity - reservedquantity) <= 5'
        )->count();

        $outOfStockCount = Inventory::whereRaw(
            '(quantity - reservedquantity) <= 0'
        )->count();

        return view('admin.inventory.index', compact(
            'inventory',
            'totalVariants',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        if ($validated['quantity'] < $inventory->reservedquantity) {
            return back()->withErrors([
                'quantity' => 'Stock cannot be lower than the reserved quantity.'
            ]);
        }

        $inventory->update([
            'quantity' => $validated['quantity'],
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }
}
