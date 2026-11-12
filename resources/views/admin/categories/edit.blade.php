
@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-heading', 'Edit Category')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Edit Category</h2>
            <p>Update your category information.</p>
        </div>
    </div>

    <div class="products-card">

        <form action="{{ route('admin.categories.update', $category->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
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
                            {{ old('parentid', $category->parentid) == $parent->id ? 'selected' : '' }}>
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
                >{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="isactive">Status</label>
                <select name="isactive" id="isactive" required>
                    <option value="1" {{ old('isactive', $category->isactive ? '1' : '0') == '1' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ old('isactive', $category->isactive ? '1' : '0') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.categories.index') }}" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Update Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
