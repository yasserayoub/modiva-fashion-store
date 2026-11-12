<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with([
                'category',
                'brand',
                'images'
            ])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'ILIKE', "%{$search}%");
            })
            ->latest('createdat')
            ->paginate(10)
            ->withQueryString();

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products',
            'brands',
            'categories'
        ));
    }

    public function create()
    {
        $categories = Category::where('isactive', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::where('isactive', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact(
            'categories',
            'brands'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categoryid' => 'required|exists:categories,id',
            'brandid' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'baseprice' => 'required|numeric|min:0',
            'saleprice' => 'nullable|numeric|min:0|lte:baseprice',
            'gender' => 'required|in:men,women,kids,unisex',
            'isfeatured' => 'required|boolean',
            'isactive' => 'required|boolean',

            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'primary_image' => 'nullable|integer|min:0',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(5)),
            'categoryid' => $validated['categoryid'],
            'brandid' => $validated['brandid'] ?? null,
            'description' => $validated['description'] ?? null,
            'baseprice' => $validated['baseprice'],
            'saleprice' => $validated['saleprice'] ?? null,
            'gender' => $validated['gender'],
            'isfeatured' => $validated['isfeatured'],
            'isactive' => $validated['isactive'],
        ]);

        if ($request->hasFile('images')) {
            $primaryImageIndex = $request->input('primary_image', 0);

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'imagepath' => $path,
                    'isprimary' => $index == $primaryImageIndex,
                    'sortorder' => $index,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'brands'
        ));
    }


public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'categoryid' => 'required|exists:categories,id',
        'brandid' => 'nullable|exists:brands,id',
        'description' => 'nullable|string',
        'baseprice' => 'required|numeric|min:0',
        'saleprice' => 'nullable|numeric|min:0|lte:baseprice',
        'gender' => 'required|in:men,women,kids,unisex',
        'isfeatured' => 'required|boolean',
        'isactive' => 'required|boolean',

        'remove_images' => 'nullable|array',
        'remove_images.*' => 'integer|exists:productimages,id',

        'images' => 'nullable|array|max:10',
        'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    // Update product information
    $product->update([
        'name' => $validated['name'],
        'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(5)),
        'categoryid' => $validated['categoryid'],
        'brandid' => $validated['brandid'] ?? null,
        'description' => $validated['description'] ?? null,
        'baseprice' => $validated['baseprice'],
        'saleprice' => $validated['saleprice'] ?? null,
        'gender' => $validated['gender'],
        'isfeatured' => $validated['isfeatured'],
        'isactive' => $validated['isactive'],
    ]);

    // Remove selected images
    $removeImages = $request->input('remove_images', []);

    if (!empty($removeImages)) {
        $imagesToRemove = $product->images()
            ->whereIn('id', $removeImages)
            ->get();

        foreach ($imagesToRemove as $image) {
            Storage::disk('public')->delete($image->imagepath);
            $image->delete();
        }
    }

    // Check whether a primary image still exists
    $currentPrimary = $product->images()
        ->where('isprimary', true)
        ->first();

    // Upload additional images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'imagepath' => $path,
                'isprimary' => !$currentPrimary && $index === 0,
                'sortorder' => $product->images()->count(),
            ]);

            if (!$currentPrimary) {
                $currentPrimary = true;
            }
        }
    }

    // If the previous primary image was removed,
    // make the first remaining image the primary image.
    $hasPrimary = $product->images()
        ->where('isprimary', true)
        ->exists();

    if (!$hasPrimary) {
        $firstImage = $product->images()
            ->orderBy('sortorder')
            ->first();

        if ($firstImage) {
            $firstImage->update([
                'isprimary' => true
            ]);
        }
    }

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product updated successfully.');
}

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
