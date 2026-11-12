<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class StorefrontController extends Controller
{
    public function index()
    {
        // Active main categories
        $categories = Category::where('isactive', true)
            ->whereNull('parentid')
            ->orderBy('name')
            ->get();

        // Featured homepage products
        $products = Product::with(['primaryImage', 'category'])
            ->where('isactive', true)
            ->orderByDesc('createdat')
            ->take(8)
            ->get();

        // Load all active products with their related data
        $allProducts = Product::with([
            'images',
            'primaryImage',
            'category',
            'brand',
            'variants' => function ($query) {
                $query->where('isactive', true);
            },
            'variants.size',
            'variants.color',
            'variants.inventory',
        ])
            ->where('isactive', true)
            ->orderByDesc('createdat')
            ->get();

        // Convert database products into JavaScript-friendly data
        $storeProducts = $allProducts->map(function ($product) {

            // Support both online URLs and local storage images
            $formatImage = function ($path) {
                if (!$path) {
                    return null;
                }

                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    return $path;
                }

                return asset('storage/' . ltrim($path, '/'));
            };

            // Product images
            $images = $product->images
                ->pluck('imagepath')
                ->filter()
                ->map(fn ($path) => $formatImage($path))
                ->filter()
                ->values()
                ->all();

            // Primary product image
            $primaryImage = $product->primaryImage
                ? $formatImage($product->primaryImage->imagepath)
                : ($images[0] ?? null);

            if ($primaryImage && !in_array($primaryImage, $images)) {
                array_unshift($images, $primaryImage);
            }

            // Actual product variants from database
            $variants = $product->variants->map(function ($variant) {

                $inventory = $variant->inventory;

                return [
                    'id' => $variant->id,

                    // Size information
                    'size' => $variant->size?->name,
                    'sizeId' => $variant->sizeid,
                    'sizeOrder' => $variant->size?->sortorder ?? 0,

                    // Color information
                    'color' => $variant->color?->name,
                    'colorId' => $variant->colorid,
                    'hexcode' => $variant->color?->hexcode ?? '#cccccc',

                    // SKU and price
                    'sku' => $variant->sku,
                    'price' => $variant->priceoverride !== null
                        ? (float) $variant->priceoverride
                        : null,

                    // Available inventory
                    'stock' => $inventory
                        ? max(
                            0,
                            $inventory->quantity - $inventory->reservedquantity
                        )
                        : 0,
                ];

            })->values()->all();

            // Product information
            return [
                'id' => $product->id,
                'name' => $product->name,
                'cat' => $product->category?->name ?? '',
                'gender' => ucfirst($product->gender),
                'brand' => $product->brand?->name ?? '',

                'price' => (float) $product->baseprice,

                'sale' => $product->saleprice !== null
                    ? (float) $product->saleprice
                    : null,

                'pop' => $product->isfeatured ? 100 : 0,

                'imgs' => $images,
                'mainImage' => $primaryImage,

                'desc' => $product->description ?? '',

                'variants' => $variants,
            ];
        });

        // Active brands
        $brands = Brand::where('isactive', true)
            ->orderBy('name')
            ->get();

        // Available genders based on active products
        $genders = $allProducts
            ->pluck('gender')
            ->filter()
            ->map(fn ($gender) => ucfirst($gender))
            ->unique()
            ->sort()
            ->values();

        return view('home', compact(
            'categories',
            'products',
            'brands',
            'storeProducts',
            'genders'
        ));
    }
}
