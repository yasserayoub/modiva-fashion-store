<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest('createdat')->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:brands,name',
            'description' => 'nullable|string',
            'logopath' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isactive' => 'required|boolean',
        ]);

        $logoPath = null;

        if ($request->hasFile('logopath')) {
            $logoPath = $request->file('logopath')->store('brands', 'public');
        }

        Brand::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'logopath' => $logoPath,
            'isactive' => $validated['isactive'],
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logopath' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isactive' => 'required|boolean',
        ]);

        $logoPath = $brand->logopath;

        if ($request->hasFile('logopath')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }

            $logoPath = $request->file('logopath')->store('brands', 'public');
        }

        $brand->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'logopath' => $logoPath,
            'isactive' => $validated['isactive'],
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logopath) {
            Storage::disk('public')->delete($brand->logopath);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
