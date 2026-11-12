
@extends('layouts.admin')

@section('title', 'Add Category')
@section('page-heading', 'Add Category')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Add New Category</h2>
            <p>Create a category for your fashion products.</p>
        </div>
    </div>

    <div class="products-card">

        <form action="{{ route('admin.categories.store') }}"
              method="POST">

            @csrf

            <div class="form-group">
                <label for="name">Category Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: Men's Clothing"
                    required
                >
                @error('name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="parentid">Parent Category</label>

                <select name="parentid" id="parentid">
                    <option value="">Main Category (None)</option>

                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}"
                            {{ old('parentid') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>

                @error('parentid')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="Describe this category..."
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="isactive">Status</label>

                <select name="isactive" id="isactive" required>
                    <option value="1" {{ old('isactive', '1') == '1' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ old('isactive') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.categories.index') }}"
                   class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Save Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
