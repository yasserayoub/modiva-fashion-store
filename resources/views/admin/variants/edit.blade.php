
@extends('layouts.admin')

@section('content')
<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Edit Product Variant</h2>
            <p>Product: {{ $product->name }}</p>
        </div>

        <a href="{{ route('admin.variants.index', $product->id) }}"
           class="cancel-btn">
            Back to Variants
        </a>
    </div>

    <div class="products-card">
        <form action="{{ route('admin.variants.update', [$product->id, $variant->id]) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="sizeid">Size</label>
                <select name="sizeid" id="sizeid" required>
                    <option value="">Select Size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}"
                            {{ old('sizeid', $variant->sizeid) == $size->id ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
                @error('sizeid')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="colorid">Color</label>
                <select name="colorid" id="colorid" required>
                    <option value="">Select Color</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}"
                            {{ old('colorid', $variant->colorid) == $color->id ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
                @error('colorid')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku"
                       value="{{ old('sku', $variant->sku) }}" required>
                @error('sku')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="priceoverride">Price Override (Optional)</label>
                <input type="number" name="priceoverride" id="priceoverride"
                       value="{{ old('priceoverride', $variant->priceoverride) }}"
                       step="0.01" min="0"
                       placeholder="Leave empty to use product price">
                @error('priceoverride')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Stock Quantity</label>
                <input type="number" name="quantity" id="quantity"
                       value="{{ old('quantity', $variant->inventory?->quantity ?? 0) }}"
                       min="0" required>
                @error('quantity')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="isactive">Status</label>
                <select name="isactive" id="isactive" required>
                    <option value="1"
                        {{ old('isactive', $variant->isactive ? '1' : '0') == '1' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0"
                        {{ old('isactive', $variant->isactive ? '1' : '0') == '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
                @error('isactive')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.variants.index', $product->id) }}"
                   class="cancel-btn">Cancel</a>

                <button type="submit" class="add-product-btn">
                    Update Variant
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
