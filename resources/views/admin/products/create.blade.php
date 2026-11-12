
@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-heading', 'Add Product')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Add New Product</h2>
            <p>Add a new product to your fashion store.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="cancel-btn">
            Back to Products
        </a>
    </div>

    <div class="products-card">

        <form action="{{ route('admin.products.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- Product Name --}}
            <div class="form-group">
                <label for="name">Product Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter product name"
                    required
                >
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div class="form-group">
                <label for="categoryid">Category</label>
                <select id="categoryid" name="categoryid" required>
                    <option value="">Select Category</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('categoryid') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('categoryid')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Brand --}}
            <div class="form-group">
                <label for="brandid">Brand</label>
                <select id="brandid" name="brandid">
                    <option value="">Select Brand (Optional)</option>

                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brandid') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>

                @error('brandid')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Describe the product..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Base Price --}}
            <div class="form-group">
                <label for="baseprice">Base Price ($)</label>
                <input
                    type="number"
                    id="baseprice"
                    name="baseprice"
                    value="{{ old('baseprice') }}"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    required
                >

                @error('baseprice')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sale Price --}}
            <div class="form-group">
                <label for="saleprice">Sale Price ($)</label>
                <input
                    type="number"
                    id="saleprice"
                    name="saleprice"
                    value="{{ old('saleprice') }}"
                    step="0.01"
                    min="0"
                    placeholder="Optional sale price"
                >

                @error('saleprice')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gender --}}
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>

                    <option value="men" {{ old('gender') == 'men' ? 'selected' : '' }}>
                        Men
                    </option>

                    <option value="women" {{ old('gender') == 'women' ? 'selected' : '' }}>
                        Women
                    </option>

                    <option value="kids" {{ old('gender') == 'kids' ? 'selected' : '' }}>
                        Kids
                    </option>

                    <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }}>
                        Unisex
                    </option>
                </select>

                @error('gender')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Featured --}}
            <div class="form-group">
                <label for="isfeatured">Featured Product</label>
                <select id="isfeatured" name="isfeatured" required>
                    <option value="0" {{ old('isfeatured', '0') == '0' ? 'selected' : '' }}>
                        No
                    </option>

                    <option value="1" {{ old('isfeatured') == '1' ? 'selected' : '' }}>
                        Yes
                    </option>
                </select>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="isactive">Status</label>
                <select id="isactive" name="isactive" required>
                    <option value="1" {{ old('isactive', '1') == '1' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0" {{ old('isactive') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            {{-- Product Images --}}
            <div class="form-group">
                <label for="images">Product Images</label>

                <input
                    type="file"
                    id="images"
                    name="images[]"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                >

                <small>Select up to 10 images. Maximum 5 MB per image.</small>

                @error('images')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                @error('images.*')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image Previews --}}
            <div id="image-preview-container"
                 style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">
            </div>

            {{-- Primary Image --}}
            <div class="form-group">
                <label for="primary_image">Primary Image</label>

                <select id="primary_image" name="primary_image">
                    <option value="0">First uploaded image</option>
                </select>

                <small>
                    Choose the main image that represents this product.
                </small>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.products.index') }}" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Save Product
                </button>
            </div>

        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('images');
    const primarySelect = document.getElementById('primary_image');
    const previewContainer = document.getElementById('image-preview-container');

    imageInput.addEventListener('change', function () {

        primarySelect.innerHTML = '';
        previewContainer.innerHTML = '';

        const files = Array.from(this.files);

        if (files.length > 10) {
            alert('You can upload a maximum of 10 images.');
            this.value = '';
            return;
        }

        files.forEach((file, index) => {

            const option = document.createElement('option');
            option.value = index;
            option.textContent = file.name;

            primarySelect.appendChild(option);

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                const wrapper = document.createElement('div');

                wrapper.style.width = '120px';
                wrapper.style.textAlign = 'center';

                const image = document.createElement('img');

                image.src = event.target.result;
                image.style.width = '120px';
                image.style.height = '120px';
                image.style.objectFit = 'cover';
                image.style.borderRadius = '8px';
                image.style.border = '1px solid #ddd';

                const filename = document.createElement('small');

                filename.textContent = file.name;
                filename.style.display = 'block';
                filename.style.marginTop = '5px';
                filename.style.overflowWrap = 'anywhere';

                wrapper.appendChild(image);
                wrapper.appendChild(filename);

                previewContainer.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });

        if (files.length === 0) {
            const option = document.createElement('option');
            option.value = 0;
            option.textContent = 'First uploaded image';

            primarySelect.appendChild(option);
        }

    });

});
</script>

@endsection
