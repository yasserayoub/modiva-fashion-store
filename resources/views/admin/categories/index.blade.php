
@extends('layouts.admin')

@section('title', 'Categories')
@section('page-heading', 'Categories')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Categories Management</h2>
            <p>Organize your store products into categories.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="add-product-btn">
            + Add Category
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
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Parent Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                {{ $category->parentCategory?->name ?? 'Main Category' }}
                            </td>
                            <td>
                                {{ $category->isactive ? 'Active' : 'Inactive' }}
                            </td>
                            <td>
    <a href="{{ route('admin.categories.edit', $category->id) }}"
       class="edit-btn">
        Edit
    </a>

    <form
        action="{{ route('admin.categories.destroy', $category->id) }}"
        method="POST"
        style="display:inline;"
        onsubmit="return confirm('Are you sure you want to delete this category?')"
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
                            <td colspan="4" class="empty-orders">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="products-pagination">
            {{ $categories->links() }}
        </div>

    </div>

</div>

@endsection
