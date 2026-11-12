
@extends('layouts.admin')

@section('title', 'Edit Brand')
@section('page-heading', 'Edit Brand')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Edit Brand</h2>
            <p>Update your brand information.</p>
        </div>
    </div>

    <div class="products-card">

        <form
            action="{{ route('admin.brands.update', $brand->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Brand Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $brand->name) }}"
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
                >{{ old('description', $brand->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Current Logo</label>

                @if($brand->logopath)
                    <img
                        src="{{ asset('storage/' . $brand->logopath) }}"
                        alt="{{ $brand->name }}"
                        width="100"
                    >
                @else
                    <p>No logo uploaded.</p>
                @endif
            </div>

            <div class="form-group">
                <label for="logopath">Change Logo</label>
                <input
                    type="file"
                    name="logopath"
                    id="logopath"
                    accept="image/jpeg,image/png,image/webp"
                >
                @error('logopath')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="isactive">Status</label>
                <select name="isactive" id="isactive" required>
                    <option value="1" {{ old('isactive', $brand->isactive ? '1' : '0') == '1' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ old('isactive', $brand->isactive ? '1' : '0') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.brands.index') }}" class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Update Brand
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
