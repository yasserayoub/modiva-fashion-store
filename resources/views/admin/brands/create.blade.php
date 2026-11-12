
@extends('layouts.admin')

@section('title', 'Add Brand')
@section('page-heading', 'Add Brand')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Add New Brand</h2>
            <p>Add a clothing brand to your store.</p>
        </div>
    </div>

    <div class="products-card">

        <form
            action="{{ route('admin.brands.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="form-group">
                <label for="name">Brand Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: Nike"
                    required
                >

                @error('name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="Describe this brand..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="logopath">Brand Logo</label>

                <input
                    type="file"
                    id="logopath"
                    name="logopath"
                    accept="image/jpeg,image/png,image/webp"
                >

                @error('logopath')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="isactive">Status</label>

                <select name="isactive" id="isactive" required>
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="form-actions">

                <a href="{{ route('admin.brands.index') }}" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Save Brand
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
