
@extends('layouts.admin')

@section('title', 'Products')
@section('page-heading', 'Products')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Products Management</h2>
            <p>Manage your fashion store products.</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="add-product-btn">
            + Add Product
        </a>
    </div>

    <div class="products-card">

        <form method="GET"
              action="{{ route('admin.products.index') }}"
              class="products-search">

            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="{{ request('search') }}"
            >

            <button type="submit">Search</button>
        </form>

        <div class="table-container">
            <table class="orders-table">

                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)

                        @php
                            $displayImage = $product->images->firstWhere('isprimary', true)
                                ?? $product->images->first();
                        @endphp

                        <tr>

                            <td>
                                @if($displayImage)
                                    <img
                                        src="{{ asset('storage/' . $displayImage->imagepath) }}"
                                        alt="{{ $product->name }}"
                                        class="product-thumbnail"
                                    >
                                @else
                                    <div class="no-product-image">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td>{{ $product->name }}</td>

                            <td>
                                {{ $product->category->name ?? '—' }}
                            </td>

                            <td>
                                {{ $product->brand->name ?? '—' }}
                            </td>

                            <td>
                                ${{ number_format($product->baseprice, 2) }}
                            </td>

                            <td>
                                {{ ucfirst($product->gender) }}
                            </td>

                            <td>
                                {{ $product->isactive ? 'Active' : 'Inactive' }}
                            </td>

                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="edit-btn">
                                    Edit
                                </a>

                                <a href="{{ route('admin.variants.index', $product->id) }}"
                                   class="edit-btn">
                                    Variants
                                </a>

                                <form
                                    action="{{ route('admin.products.destroy', $product->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty-orders">
                                No products found.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="products-pagination">
            {{ $products->links() }}
        </div>

    </div>

</div>

<style>
    .product-thumbnail {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 7px;
        border: 1px solid #e5e5e5;
        display: block;
    }

    .no-product-image {
        width: 65px;
        height: 65px;
        background: #f0f0f0;
        color: #888;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }
</style>

@endsection
