
@extends('layouts.admin')

@section('title', 'Inventory Management')
@section('page-heading', 'Inventory Management')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Inventory Management</h2>
            <p>Monitor and manage stock across your product variants.</p>
        </div>
    </div>

    <!-- Inventory Statistics -->
    <div style="
        display:grid;
        grid-template-columns:repeat(3, 1fr);
        gap:18px;
        margin-bottom:25px;
    ">

        <div class="products-card" style="padding:22px;">
            <p style="color:#777; margin:0 0 10px;">Total Variants</p>
            <h2 style="margin:0;">{{ $totalVariants }}</h2>
        </div>

        <div class="products-card" style="padding:22px;">
            <p style="color:#d97706; margin:0 0 10px;">Low Stock</p>
            <h2 style="margin:0; color:#d97706;">{{ $lowStockCount }}</h2>
            <small>1–5 available units</small>
        </div>

        <div class="products-card" style="padding:22px;">
            <p style="color:#dc2626; margin:0 0 10px;">Out of Stock</p>
            <h2 style="margin:0; color:#dc2626;">{{ $outOfStockCount }}</h2>
            <small>No available units</small>
        </div>

    </div>

    <!-- Search and Filters -->
    <div class="products-card" style="padding:22px; margin-bottom:25px;">

        <form action="{{ route('admin.inventory.index') }}" method="GET">

            <div style="
                display:grid;
                grid-template-columns:2fr 1fr auto auto;
                gap:12px;
                align-items:end;
            ">

                <div class="form-group">
                    <label for="search">Search Product or SKU</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Enter product name or SKU..."
                    >
                </div>

                <div class="form-group">
                    <label for="stock">Stock Status</label>

                    <select name="stock" id="stock">
                        <option value="">All Stock</option>
                        <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>
                            Low Stock
                        </option>
                        <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>
                            Out of Stock
                        </option>
                    </select>
                </div>

                <button type="submit" class="add-product-btn">
                    Search
                </button>

                <a href="{{ route('admin.inventory.index') }}" class="cancel-btn">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <!-- Inventory Table -->
    <div class="products-card" style="padding:24px;">

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('quantity'))
            <div class="error-message" style="display:block; margin-bottom:15px;">
                {{ $errors->first('quantity') }}
            </div>
        @endif

        <h3 style="margin-top:0; margin-bottom:20px;">Product Stock</h3>

        <div class="table-container">

            <table class="orders-table">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Total Stock</th>
                        <th>Reserved</th>
                        <th>Available</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($inventory as $item)

                        @php
                            $variant = $item->productVariant;
                            $available = $item->quantity - $item->reservedquantity;
                        @endphp

                        <tr>

                            <td>
                                <strong>
                                    {{ $variant?->product?->name ?? 'Unknown Product' }}
                                </strong>
                            </td>

                            <td>{{ $variant?->sku ?? '-' }}</td>

                            <td>{{ $variant?->size?->name ?? '-' }}</td>

                            <td>
                                @if($variant?->color)
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="
                                            width:18px;
                                            height:18px;
                                            border-radius:50%;
                                            background:{{ $variant->color->hexcode }};
                                            border:1px solid #ddd;
                                            display:inline-block;
                                        "></span>

                                        {{ $variant->color->name }}
                                    </div>
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $item->quantity }}</td>

                            <td>{{ $item->reservedquantity }}</td>

                            <td>
                                <strong>{{ $available }}</strong>
                            </td>

                            <td>
                                @if($available <= 0)
                                    <span style="color:#dc2626; font-weight:600;">
                                        Out of Stock
                                    </span>
                                @elseif($available <= 5)
                                    <span style="color:#d97706; font-weight:600;">
                                        Low Stock
                                    </span>
                                @else
                                    <span style="color:#16a34a; font-weight:600;">
                                        In Stock
                                    </span>
                                @endif
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="edit-btn"
                                    onclick="openStockModal(
                                        {{ $item->id }},
                                        {{ $item->quantity }},
                                        {{ $item->reservedquantity }}
                                    )"
                                >
                                    Update Stock
                                </button>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty-orders">
                                No inventory records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div style="margin-top:20px;">
            {{ $inventory->links() }}
        </div>

    </div>

</div>

<!-- Update Stock Modal -->
<div id="stockModal" class="stock-modal">

    <div class="stock-modal-content">

        <h3>Update Inventory</h3>

        <form id="stockForm" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="quantity">Total Stock Quantity</label>

                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    min="0"
                    required
                >

                <small id="reservedInfo" style="display:block; margin-top:8px; color:#777;"></small>
            </div>

            <div class="form-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeStockModal()"
                >
                    Cancel
                </button>

                <button type="submit" class="add-product-btn">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

<style>
.stock-modal {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.stock-modal-content {
    background:white;
    width:100%;
    max-width:450px;
    padding:25px;
    border-radius:10px;
}

.stock-modal-content h3 {
    margin-top:0;
    margin-bottom:20px;
}

.stock-modal-content .form-group {
    margin-bottom:20px;
}

.stock-modal-content input {
    width:100%;
    box-sizing:border-box;
}

.stock-modal-content .form-actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

@media(max-width:900px) {
    .products-page form > div[style*="grid-template-columns"] {
        grid-template-columns:1fr 1fr !important;
    }
}

@media(max-width:600px) {
    .products-page > div[style*="grid-template-columns"] {
        grid-template-columns:1fr !important;
    }

    .products-page form > div[style*="grid-template-columns"] {
        grid-template-columns:1fr !important;
    }
}
</style>

<script>
function openStockModal(id, quantity, reserved) {

    document.getElementById('quantity').value = quantity;

    document.getElementById('quantity').min = reserved;

    document.getElementById('reservedInfo').textContent =
        'Reserved stock: ' + reserved +
        '. Total stock cannot be lower than this amount.';

    document.getElementById('stockForm').action =
        "{{ url('/admin/inventory') }}/" + id;

    document.getElementById('stockModal').style.display = 'flex';
}

function closeStockModal() {
    document.getElementById('stockModal').style.display = 'none';
}

document.getElementById('stockModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeStockModal();
    }
});
</script>

@endsection
