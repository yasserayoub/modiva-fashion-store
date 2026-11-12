
@extends('layouts.admin')

@section('title', 'Product Variants')
@section('page-heading', 'Product Variants')

@section('content')

<div class="products-page variants-page">

    <div class="products-header">
        <div>
            <h2>Product Variants</h2>
            <p>Manage sizes, colors and inventory for {{ $product->name }}.</p>
        </div>

        <div class="variants-header-actions">
            <a href="{{ route('admin.products.index') }}" class="cancel-btn">
                Back to Products
            </a>

            <a href="{{ route('admin.variants.create', $product->id) }}"
               class="add-product-btn">
                + Add Variant
            </a>
        </div>
    </div>

    <div class="products-card variants-card">

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="orders-table variants-table">

                <thead>
                    <tr>
                        <th class="size-column">Size</th>
                        <th>Available Colors & Details</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $groupedVariants = $product->variants->groupBy('sizeid');
                    @endphp

                    @forelse($groupedVariants as $sizeVariants)

                        <tr>
                            <td class="size-cell">
                                <span class="size-label">
                                    {{ $sizeVariants->first()->size->name ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <div class="variant-cards">

                                    @foreach($sizeVariants as $variant)

                                        <div class="variant-card">

                                            <div class="variant-color-heading">

                                                @if($variant->color && $variant->color->hexcode)
                                                    <span class="color-circle"
                                                          style="background-color: {{ $variant->color->hexcode }};">
                                                    </span>
                                                @endif

                                                <span class="color-name">
                                                    {{ $variant->color->name ?? '—' }}
                                                </span>

                                                <span class="variant-status {{ $variant->isactive ? 'active' : 'inactive' }}">
                                                    {{ $variant->isactive ? 'Active' : 'Inactive' }}
                                                </span>

                                            </div>

                                            <div class="variant-details">

                                                <div class="detail-item">
                                                    <span class="detail-label">SKU</span>
                                                    <span class="detail-value">{{ $variant->sku }}</span>
                                                </div>

                                                <div class="detail-item">
                                                    <span class="detail-label">Price</span>
                                                    <span class="detail-value">
                                                        ${{ number_format($variant->priceoverride ?? $product->baseprice, 2) }}
                                                    </span>
                                                </div>

                                                <div class="detail-item">
                                                    <span class="detail-label">Stock</span>
                                                    <span class="detail-value">
                                                        {{ $variant->inventory->quantity ?? 0 }} units
                                                    </span>
                                                </div>

                                                <div class="detail-item">
                                                    <span class="detail-label">Reserved</span>
                                                    <span class="detail-value">
                                                        {{ $variant->inventory->reservedquantity ?? 0 }} units
                                                    </span>
                                                </div>

                                            </div>

                                            <div class="variant-actions">

                                                <a href="{{ route('admin.variants.edit', [
                                                    $product->id,
                                                    $variant->id
                                                ]) }}" class="edit-btn">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.variants.destroy', [
                                                        $product->id,
                                                        $variant->id
                                                    ]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this variant?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="delete-btn">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="2" class="empty-orders">
                                No variants found for this product.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.variants-page {
    font-family: 'Inter', sans-serif;
    color: #202633;
}

.variants-page .products-header h2 {
    font-size: 25px;
    font-weight: 700;
    letter-spacing: -0.6px;
}

.variants-page .products-header p {
    font-size: 13px;
    color: #77808f;
    font-weight: 400;
}

.variants-header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.variants-card {
    padding: 24px;
    border-radius: 12px;
}

.variants-table {
    border-collapse: separate;
    border-spacing: 0;
    font-family: 'Inter', sans-serif;
}

.variants-table th {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    color: #77808f;
    padding: 17px 15px;
    background: #f8f9fb;
}

.variants-table td {
    padding: 20px 15px;
    border-bottom: 1px solid #edf0f4;
    vertical-align: top;
}

.size-column {
    width: 100px;
}

.size-cell {
    padding-top: 25px !important;
}

.size-label {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    min-width: 48px;
    padding: 9px 13px;
    background: #202633;
    color: white;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 700;
}

.variant-cards {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    gap: 14px;
}

.variant-card {
    width: 240px;
    padding: 15px;
    border: 1px solid #e9edf2;
    border-radius: 10px;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.variant-card:hover {
    border-color: #cbd3df;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
}

.variant-color-heading {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 13px;
    border-bottom: 1px solid #edf0f4;
}

.color-circle {
    width: 19px;
    height: 19px;
    flex-shrink: 0;
    border-radius: 50%;
    border: 1px solid #d5d9df;
}

.color-name {
    font-size: 14px;
    font-weight: 600;
    color: #202633;
}

.variant-status {
    margin-left: auto;
    font-size: 10px;
    font-weight: 600;
    padding: 5px 8px;
    border-radius: 20px;
}

.variant-status.active {
    color: #16803c;
    background: #e9f7ee;
}

.variant-status.inactive {
    color: #c62828;
    background: #fdeaea;
}

.variant-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 13px 8px;
    padding: 15px 0;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 0;
}

.detail-label {
    font-size: 10px;
    font-weight: 600;
    color: #929aa7;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 12px;
    font-weight: 600;
    color: #303948;
    overflow-wrap: anywhere;
}

.variant-actions {
    display: flex;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid #edf0f4;
}

.variant-actions form {
    display: inline;
}

.variant-actions .edit-btn,
.variant-actions .delete-btn {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 600;
    padding: 7px 13px;
}

@media (max-width: 700px) {
    .variants-card {
        padding: 12px;
    }

    .variant-card {
        width: 100%;
    }

    .variants-table td {
        padding: 12px 8px;
    }
}
</style>

@endsection
