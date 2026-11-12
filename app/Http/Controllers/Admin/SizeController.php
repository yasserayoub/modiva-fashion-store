<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    // Display all sizes
    public function index()
    {
        $sizes = Size::withCount('variants')
            ->orderBy('sortorder')
            ->get();

        return view('admin.sizes.index', compact('sizes'));
    }

    // Store a new size
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:sizes,name',
            ],
            'sortorder' => 'required|integer|min:0',
        ]);

        Size::create($validated);

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Size added successfully.');
    }

    // Update an existing size
    public function update(Request $request, Size $size)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sizes', 'name')->ignore($size->id),
            ],
            'sortorder' => 'required|integer|min:0',
        ]);

        $size->update($validated);

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Size updated successfully.');
    }

    // Delete a size
    public function destroy(Size $size)
    {
        if ($size->variants()->exists()) {
            return redirect()
                ->route('admin.sizes.index')
                ->with('error', 'This size is assigned to product variants and cannot be deleted.');
        }

        $size->delete();

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Size deleted successfully.');
    }
}
