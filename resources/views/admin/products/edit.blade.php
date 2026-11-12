
@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-heading', 'Edit Product')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Edit Product</h2>
            <p>Update your product information and images.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="cancel-btn">
            Back to Products
        </a>
    </div>

    <div class="products-card">

        <form action="{{ route('admin.products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="categoryid">Category</label>
                <select id="categoryid" name="categoryid" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('categoryid', $product->categoryid) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categoryid')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="brandid">Brand</label>
                <select id="brandid" name="brandid">
                    <option value="">Select Brand (Optional)</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brandid', $product->brandid) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brandid')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="baseprice">Base Price ($)</label>
                <input type="number" id="baseprice" name="baseprice"
                       value="{{ old('baseprice', $product->baseprice) }}"
                       step="0.01" min="0" required>
                @error('baseprice')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="saleprice">Sale Price ($)</label>
                <input type="number" id="saleprice" name="saleprice"
                       value="{{ old('saleprice', $product->saleprice) }}"
                       step="0.01" min="0">
                @error('saleprice')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="men" {{ old('gender', $product->gender) == 'men' ? 'selected' : '' }}>Men</option>
                    <option value="women" {{ old('gender', $product->gender) == 'women' ? 'selected' : '' }}>Women</option>
                    <option value="kids" {{ old('gender', $product->gender) == 'kids' ? 'selected' : '' }}>Kids</option>
                    <option value="unisex" {{ old('gender', $product->gender) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
                @error('gender')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="isfeatured">Featured Product</label>
                <select id="isfeatured" name="isfeatured" required>
                    <option value="0" {{ old('isfeatured', $product->isfeatured ? '1' : '0') == '0' ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('isfeatured', $product->isfeatured ? '1' : '0') == '1' ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

            <div class="form-group">
                <label for="isactive">Status</label>
                <select id="isactive" name="isactive" required>
                    <option value="1" {{ old('isactive', $product->isactive ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('isactive', $product->isactive ? '1' : '0') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <hr>

            <div class="form-group">
                <label>Current Product Images</label>

                @if($product->images->count())
                    <div class="existing-images">
                        @foreach($product->images as $image)
                            <div class="existing-image-item">

                                <img
                                    src="{{ asset('storage/' . $image->imagepath) }}"
                                    alt="{{ $product->name }}"
                                >

                                @if($image->isprimary)
                                    <span class="primary-label">Primary Image</span>
                                @endif

                                <label class="remove-image-label">
                                    <input
                                        type="checkbox"
                                        name="remove_images[]"
                                        value="{{ $image->id }}"
                                    >
                                    Remove this image
                                </label>

                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No images uploaded for this product.</p>
                @endif

                @error('remove_images')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="images">Add More Images</label>
                <input
                    type="file"
                    id="images"
                    name="images[]"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                >
                <small>You can select up to 10 additional images.</small>

                @error('images')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                @error('images.*')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.products.index') }}" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Update Product
                </button>
            </div>

        </form>

    </div>

</div>

<style>
    .existing-images {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 15px;
    }

    .existing-image-item {
        width: 150px;
        padding: 10px;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        background: #fff;
    }

    .existing-image-item img {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 6px;
    }

    .primary-label {
        display: block;
        margin-top: 8px;
        color: #16834a;
        font-size: 12px;
        font-weight: bold;
    }

    .remove-image-label {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
        color: #c62828;
        font-size: 12px;
        cursor: pointer;
    }

    .remove-image-label input {
        width: auto;
    }
</style>

@endsection
