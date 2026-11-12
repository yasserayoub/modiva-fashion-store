
@extends('layouts.admin')

@section('content')
<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Add Product Variants</h2>
            <p>Product: {{ $product->name }}</p>
        </div>

        <a href="{{ route('admin.variants.index', $product->id) }}"
           class="cancel-btn">
            Back to Variants
        </a>
    </div>

    <div class="products-card">

        <form action="{{ route('admin.variants.store', $product->id) }}"
              method="POST">
            @csrf

            <div class="form-group">
                <label>Select Sizes</label>

                <div class="variant-options">
                    @foreach($sizes as $size)
                        <label class="variant-option">
                            <input type="checkbox"
                                   name="sizeids[]"
                                   value="{{ $size->id }}"
                                   {{ in_array($size->id, old('sizeids', [])) ? 'checked' : '' }}>
                            {{ $size->name }}
                        </label>
                    @endforeach
                </div>

                @error('sizeids')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                @error('sizeids.*')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Select Colors</label>

                <div class="variant-options">
                    @foreach($colors as $color)
                        <label class="variant-option">
                            <input type="checkbox"
                                   name="colorids[]"
                                   value="{{ $color->id }}"
                                   {{ in_array($color->id, old('colorids', [])) ? 'checked' : '' }}>

                            <span class="color-circle"
                                  style="background-color: {{ $color->hexcode }};">
                            </span>

                            {{ $color->name }}
                        </label>
                    @endforeach
                </div>

                @error('colorids')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                @error('colorids.*')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="priceoverride">Price Override (Optional)</label>
                <input type="number"
                       name="priceoverride"
                       id="priceoverride"
                       value="{{ old('priceoverride') }}"
                       step="0.01"
                       min="0"
                       placeholder="Leave empty to use product price">

                @error('priceoverride')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Initial Stock Quantity (per combination)</label>
                <input type="number"
                       name="quantity"
                       id="quantity"
                       value="{{ old('quantity', 0) }}"
                       min="0"
                       required>

                @error('quantity')
                    <span class="error-message">{{ $message }}</span>
                @enderror
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
                <a href="{{ route('admin.variants.index', $product->id) }}"
                   class="cancel-btn">
                    Cancel
                </a>

                <button type="submit" class="add-product-btn">
                    Generate Variants
                </button>
            </div>

        </form>
    </div>
</div>

<style>
.variant-options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 10px;
}

.variant-option {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
}

.variant-option:hover {
    background: #f5f7fa;
}

.variant-option input {
    cursor: pointer;
}

.color-circle {
    width: 17px;
    height: 17px;
    border: 1px solid #ccc;
    border-radius: 50%;
    display: inline-block;
}
</style>
@endsection
