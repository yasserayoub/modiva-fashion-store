
@extends('layouts.admin')

@section('content')
<div class="customer-details-page">

    <div class="page-header">
        <div>
            <h1>Customer Details</h1>
            <p>View customer information, addresses and orders.</p>
        </div>

        <a href="{{ route('admin.customers.index') }}" class="back-btn">
            ← Back to Customers
        </a>
    </div>

    {{-- Customer Information --}}
    <div class="details-card">
        <div class="card-heading">
            <h2>Personal Information</h2>
            <span class="{{ $customer->isactive ? 'status-active' : 'status-inactive' }}">
                {{ $customer->isactive ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div class="info-grid">
            <div>
                <label>Full Name</label>
                <p>{{ $customer->firstname }} {{ $customer->lastname }}</p>
            </div>

            <div>
                <label>Email Address</label>
                <p>{{ $customer->email }}</p>
            </div>

            <div>
                <label>Phone Number</label>
                <p>{{ $customer->phone ?: 'Not provided' }}</p>
            </div>

            <div>
                <label>Registration Date</label>
                <p>{{ $customer->createdat?->format('M d, Y') ?? 'N/A' }}</p>
            </div>

            <div>
                <label>Customer ID</label>
                <p>#{{ $customer->id }}</p>
            </div>

            <div>
                <label>Total Orders</label>
                <p>{{ $customer->orders->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Customer Addresses --}}
    <div class="details-card">
        <div class="card-heading">
            <h2>Addresses</h2>
            <span>{{ $customer->addresses->count() }} addresses</span>
        </div>

        @forelse($customer->addresses as $address)
            <div class="address-item">
                <div class="address-heading">
                    <strong>{{ $address->addresstype ?: 'Address' }}</strong>

                    @if($address->isdefault)
                        <span class="default-badge">Default</span>
                    @endif
                </div>

                <p>{{ $address->fullname }}</p>
                <p>{{ $address->phone }}</p>
                <p>
                    {{ $address->building ? $address->building . ', ' : '' }}
                    {{ $address->street }},
                    {{ $address->area }},
                    {{ $address->city }},
                    {{ $address->country }}
                </p>

                @if($address->apartment)
                    <p>Apartment: {{ $address->apartment }}</p>
                @endif
            </div>
        @empty
            <p class="empty-message">This customer has no saved addresses.</p>
        @endforelse
    </div>

    {{-- Order History --}}
    <div class="details-card">
        <div class="card-heading">
            <h2>Order History</h2>
            <span>{{ $customer->orders->count() }} orders</span>
        </div>

        @forelse($customer->orders as $order)
            <div class="order-item">
                <div class="order-heading">
                    <div>
                        <strong>{{ $order->ordernumber }}</strong>
                        <p>{{ $order->createdat?->format('M d, Y') ?? 'N/A' }}</p>
                    </div>

                    <div class="order-total">
                        ${{ number_format($order->totalamount, 2) }}
                    </div>
                </div>

                <div class="order-meta">
                    <span>Order Status: {{ ucfirst($order->orderstatus) }}</span>
                    <span>Payment: {{ ucfirst($order->paymentstatus) }}</span>
                    <span>{{ $order->order_items_count ?? $order->orderItems->count() }} items</span>
                </div>

                <a href="{{ route('admin.orders.show', $order->id) }}" class="view-order-btn">
                    View Order →
                </a>
            </div>
        @empty
            <p class="empty-message">This customer has not placed any orders yet.</p>
        @endforelse
    </div>

</div>

<style>
.customer-details-page {
    max-width: 1200px;
    margin: auto;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.page-header h1 {
    font-size: 26px;
    margin: 0 0 6px;
    color: #222;
}

.page-header p {
    color: #777;
    margin: 0;
}

.back-btn, .view-order-btn {
    display: inline-block;
    text-decoration: none;
    color: #fff;
    background: #222;
    padding: 10px 16px;
    border-radius: 7px;
    font-size: 13px;
}

.details-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 22px;
}

.card-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 22px;
}

.card-heading h2 {
    font-size: 18px;
    margin: 0;
    color: #222;
}

.card-heading > span {
    color: #777;
    font-size: 13px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.info-grid label {
    display: block;
    font-size: 12px;
    color: #888;
    margin-bottom: 7px;
}

.info-grid p {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    overflow-wrap: anywhere;
}

.status-active, .status-inactive, .default-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.status-active {
    background: #e8f7ee;
    color: #21864b;
}

.status-inactive {
    background: #fceaea;
    color: #c0392b;
}

.address-item, .order-item {
    border: 1px solid #eee;
    border-radius: 9px;
    padding: 17px;
    margin-bottom: 12px;
}

.address-heading, .order-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}

.address-item p {
    font-size: 13px;
    color: #666;
    margin: 6px 0;
}

.default-badge {
    background: #eaf1ff;
    color: #315da8;
}

.order-heading strong {
    color: #222;
    font-size: 14px;
}

.order-heading p {
    color: #888;
    font-size: 12px;
    margin: 5px 0 0;
}

.order-total {
    font-weight: 700;
    color: #222;
}

.order-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 12px;
    color: #777;
    margin: 15px 0;
}

.view-order-btn {
    font-size: 12px;
    padding: 8px 13px;
}

.empty-message {
    color: #888;
    font-size: 13px;
    padding: 10px 0;
}

@media (max-width: 650px) {
    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .details-card {
        padding: 17px;
    }
}
</style>
@endsection
