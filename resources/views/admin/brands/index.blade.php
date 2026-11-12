
@extends('layouts.admin')

@section('title', 'Brands')
@section('page-heading', 'Brands')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Brands Management</h2>
            <p>Manage the brands available in your fashion store.</p>
        </div>

        <a href="{{ route('admin.brands.create') }}" class="add-product-btn">
            + Add Brand
        </a>
    </div>

    <div class="products-card">

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="orders-table">

                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Brand Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td>
                                @if($brand->logopath)
                                    <img
                                        src="{{ asset('storage/' . $brand->logopath) }}"
                                        alt="{{ $brand->name }}"
                                        width="45"
                                        height="45"
                                        style="object-fit: contain;"
                                    >
                                @else
                                    No Logo
                                @endif
                            </td>

                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->slug }}</td>
                            <td>{{ $brand->description ?: '—' }}</td>

                            <td>
                                {{ $brand->isactive ? 'Active' : 'Inactive' }}
                            </td>
                            <td>
    <a href="{{ route('admin.brands.edit', $brand->id) }}"
       class="edit-btn">
        Edit
    </a>

    <form
        action="{{ route('admin.brands.destroy', $brand->id) }}"
        method="POST"
        style="display:inline;"
        onsubmit="return confirm('Are you sure you want to delete this brand?')"
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
                            <td colspan="5" class="empty-orders">
                                No brands found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="products-pagination">
            {{ $brands->links() }}
        </div>

    </div>

</div>

@endsection
