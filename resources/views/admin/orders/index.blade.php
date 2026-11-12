
@extends('layouts.admin')

@section('title', 'Order Management')
@section('page-heading', 'Order Management')

@section('content')

<div class="products-page">

    <div class="products-header">
        <div>
            <h2>Order Management</h2>
            <p>View and manage customer orders.</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="products-card" style="padding:22px; margin-bottom:25px;">

        <form action="{{ route('admin.orders.index') }}" method="GET">

            <div style="
                display:grid;
                grid-template-columns:2fr 1fr auto auto;
                gap:12px;
                align-items:end;
            ">

                <div class="form-group">
                    <label for="search">Search Orders</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Order number or customer..."
                    >
                </div>

                <div class="form-group">
                    <label for="status">Order Status</label>

                    <select name="status" id="status">
                        <option value="">All Orders</option>

                        @foreach(['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'] as $status)
                            <option
                                value="{{ $status }}"
                                {{ request('status') === $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="add-product-btn">
                    Search
                </button>

                <a href="{{ route('admin.orders.index') }}" class="cancel-btn">
                    Reset
                </a>

            </div>

        </form>

    </div>

    <!-- Orders Table -->
    <div class="products-card" style="padding:24px;">

        <h3 style="margin-top:0; margin-bottom:20px;">All Orders</h3>

        <div class="table-container">

            <table class="orders-table">

                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Order Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $order)

                        <tr>

                            <td>
                                <strong>{{ $order->ordernumber }}</strong>
                            </td>

                            <td>
                                @if($order->user)
                                    <strong>
                                        {{ $order->user->firstname }}
                                        {{ $order->user->lastname }}
                                    </strong>
                                    <br>
                                    <small>{{ $order->user->email }}</small>
                                @else
                                    Unknown Customer
                                @endif
                            </td>

                            <td>
                                {{ $order->createdat?->format('d M Y') ?? '-' }}
                            </td>

                            <td>{{ $order->order_items_count }}</td>

                            <td>
                                <strong>
                                    ${{ number_format((float)$order->totalamount, 2) }}
                                </strong>
                            </td>

                            <td>
                                @php
                                    $paymentStatus = strtolower($order->paymentstatus ?? 'pending');
                                @endphp

                                <span class="order-status-badge
                                    {{ $paymentStatus === 'paid' ? 'status-success' : 'status-warning' }}">
                                    {{ ucfirst($order->paymentstatus ?? 'Pending') }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $orderStatus = strtolower($order->orderstatus ?? 'pending');

                                    $statusClass = match($orderStatus) {
                                        'delivered' => 'status-success',
                                        'cancelled' => 'status-danger',
                                        'shipped' => 'status-info',
                                        'processing' => 'status-warning',
                                        default => 'status-neutral',
                                    };
                                @endphp

                                <span class="order-status-badge {{ $statusClass }}">
                                    {{ ucfirst($order->orderstatus ?? 'Pending') }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.orders.show', $order->id) }}"
                                    class="edit-btn"
                                >
                                    View Details
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty-orders">
                                No orders found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div style="margin-top:20px;">
            {{ $orders->links() }}
        </div>

    </div>

</div>

<style>
.order-status-badge {
    display:inline-block;
    padding:6px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    white-space:nowrap;
}

.status-success {
    background:#dcfce7;
    color:#166534;
}

.status-warning {
    background:#fef3c7;
    color:#92400e;
}

.status-danger {
    background:#fee2e2;
    color:#991b1b;
}

.status-info {
    background:#dbeafe;
    color:#1e40af;
}

.status-neutral {
    background:#f1f5f9;
    color:#475569;
}

@media(max-width:900px) {
    .products-page form > div[style*="grid-template-columns"] {
        grid-template-columns:1fr 1fr !important;
    }
}

@media(max-width:600px) {
    .products-page form > div[style*="grid-template-columns"] {
        grid-template-columns:1fr !important;
    }
}
</style>

@endsection
