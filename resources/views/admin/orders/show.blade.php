
@extends('layouts.admin')

@section('page-heading', 'Order Details')

@section('content')

<div class="order-details-page">

    {{-- Header --}}
    <div class="details-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.orders.index') }}">Orders</a>
                <span>/</span>
                <span>Order Details</span>
            </div>

            <h2>Order Details</h2>
            <p>Manage and review customer order information.</p>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="back-button">
            <span>←</span> Back to Orders
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="order-alert success">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="order-alert error">
            Please check the order information and try again.
        </div>
    @endif

    {{-- Order Overview --}}
    <div class="overview-card">

        <div class="overview-top">
            <div>
                <span class="section-label">ORDER NUMBER</span>
                <h3>{{ $order->ordernumber }}</h3>
                <span class="order-date">
                    Placed {{ $order->createdat?->format('d M Y, h:i A') ?? 'N/A' }}
                </span>
            </div>

            <div class="overview-badges">
                <span class="status-badge status-{{ strtolower($order->orderstatus ?? 'pending') }}">
                    {{ ucfirst($order->orderstatus ?? 'Pending') }}
                </span>

                <span class="payment-badge">
                    Payment: {{ ucfirst($order->paymentstatus ?? 'Pending') }}
                </span>
            </div>
        </div>

        <div class="overview-divider"></div>

        <div class="overview-bottom">

            <div class="overview-item">
                <span>Customer</span>
                <strong>
                    {{ $order->user?->firstname ?? 'Unknown' }}
                    {{ $order->user?->lastname ?? '' }}
                </strong>
            </div>

            <div class="overview-item">
                <span>Items</span>
                <strong>{{ $order->orderItems->sum('quantity') }} units</strong>
            </div>

            <div class="overview-item">
                <span>Order Total</span>
                <strong class="overview-total">
                    ${{ number_format((float) $order->totalamount, 2) }}
                </strong>
            </div>

        </div>
    </div>

    {{-- Main Layout --}}
    <div class="details-layout">

        {{-- Left Column --}}
        <div class="details-main">

            {{-- Products --}}
            <div class="details-card">
                <div class="card-heading">
                    <div>
                        <h3>Ordered Products</h3>
                        <p>Products included in this order</p>
                    </div>

                    <span class="item-count">
                        {{ $order->orderItems->count() }} items
                    </span>
                </div>

                <div class="products-table-wrapper">
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="product-name">
                                            <strong>{{ $item->productname }}</strong>
                                            <small>{{ $item->sku }}</small>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="variant-info">
                                            <span>{{ $item->sizename }}</span>
                                            <span>{{ $item->colorname }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        ${{ number_format((float) $item->unitprice, 2) }}
                                    </td>

                                    <td>
                                        <span class="quantity-badge">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>

                                    <td class="price-cell">
                                        ${{ number_format((float) $item->subtotal, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-row">
                                        No products found for this order.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="details-card">
                <div class="card-heading">
                    <div>
                        <h3>Shipping Address</h3>
                        <p>Customer delivery information</p>
                    </div>

                    <div class="heading-icon">⌖</div>
                </div>

                @php
                    $shippingAddress = $order->shippingaddresssnapshot ?? [];
                @endphp

                @if(!empty($shippingAddress))
                    <div class="information-grid">
                        @foreach($shippingAddress as $label => $value)
                            @if(!is_array($value) && !is_object($value))
                                <div class="information-item">
                                    <span>{{ ucfirst($label) }}</span>
                                    <strong>{{ $value ?: 'N/A' }}</strong>
                                </div>
                            @endif
                        @endforeach
                    </div>

                @elseif($order->address)

                    <div class="information-grid">
                        <div class="information-item">
                            <span>Full Name</span>
                            <strong>{{ $order->address->fullname }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Phone</span>
                            <strong>{{ $order->address->phone }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Country</span>
                            <strong>{{ $order->address->country }}</strong>
                        </div>

                        <div class="information-item">
                            <span>City</span>
                            <strong>{{ $order->address->city }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Area</span>
                            <strong>{{ $order->address->area }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Street</span>
                            <strong>{{ $order->address->street }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Building</span>
                            <strong>{{ $order->address->building }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Apartment</span>
                            <strong>{{ $order->address->apartment }}</strong>
                        </div>
                    </div>

                @else
                    <p class="empty-message">No shipping address available.</p>
                @endif
            </div>

            {{-- Payment Information --}}
            <div class="details-card">
                <div class="card-heading">
                    <div>
                        <h3>Payment Information</h3>
                        <p>Transaction and payment details</p>
                    </div>

                    <div class="heading-icon">＄</div>
                </div>

                @if($order->payment)

                    <div class="information-grid">
                        <div class="information-item">
                            <span>Payment Method</span>
                            <strong>{{ ucwords(str_replace('_', ' ', $order->payment->paymentmethod ?? 'N/A')) }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Transaction Reference</span>
                            <strong>{{ $order->payment->transactionreference ?: 'N/A' }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Amount</span>
                            <strong>${{ number_format((float) $order->payment->amount, 2) }}</strong>
                        </div>

                        <div class="information-item">
                            <span>Payment Status</span>
                            <strong>
                                <span class="payment-status-text {{ strtolower($order->payment->status ?? 'pending') === 'paid' ? 'is-paid' : 'is-pending' }}">
                                    {{ ucfirst($order->payment->status ?? 'Pending') }}
                                </span>
                            </strong>
                        </div>

                        <div class="information-item">
                            <span>Paid At</span>
                            <strong>{{ $order->payment->paidat?->format('d M Y, h:i A') ?? 'Not paid yet' }}</strong>
                        </div>
                    </div>

                    @if(($order->paymentstatus ?? $order->payment->status) !== 'paid')
                        <div class="payment-action">
                            <p>
                                For cash on delivery, confirm payment only after the customer has received the order and paid.
                            </p>

                            <form
                                action="{{ route('admin.orders.markAsPaid', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('Confirm that the customer has paid for this order? This will mark the payment as paid.');"
                            >
                                @csrf
                                @method('PUT')

                                <button type="submit" class="mark-paid-button">
                                    ✓ Mark Payment as Paid
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="payment-confirmed-message">
                            ✓ Payment has been confirmed.
                        </div>
                    @endif

                @else
                    <div class="empty-message">
                        <span>ⓘ</span>
                        No payment information has been recorded for this order. A payment record is required before it can be confirmed here.
                    </div>
                @endif
            </div>

            {{-- Order Notes --}}
            @if($order->notes)
                <div class="details-card">
                    <div class="card-heading">
                        <div>
                            <h3>Order Notes</h3>
                            <p>Additional information</p>
                        </div>
                    </div>

                    <div class="notes-content">
                        {{ $order->notes }}
                    </div>
                </div>
            @endif

        </div>

        {{-- Right Column --}}
        <div class="details-sidebar">

            {{-- Update Status --}}
            <div class="details-card status-card">
                <div class="card-heading">
                    <div>
                        <h3>Order Status</h3>
                        <p>Update order progress</p>
                    </div>
                </div>

                <div class="current-status">
                    <span>Current Status</span>
                    <strong class="status-badge status-{{ strtolower($order->orderstatus ?? 'pending') }}">
                        {{ ucfirst($order->orderstatus ?? 'Pending') }}
                    </strong>
                </div>

                <form
                    action="{{ route('admin.orders.updateStatus', $order->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="orderstatus">Change Status</label>

                        <select name="orderstatus" id="orderstatus" required>
                            @foreach([
                                'pending',
                                'processing',
                                'shipped',
                                'delivered',
                                'cancelled'
                            ] as $status)
                                <option
                                    value="{{ $status }}"
                                    {{ old('orderstatus', $order->orderstatus) === $status ? 'selected' : '' }}
                                >
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>

                        @error('orderstatus')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="update-status-button">
                        Update Order Status
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="details-card summary-card">
                <div class="card-heading">
                    <div>
                        <h3>Order Summary</h3>
                        <p>Payment breakdown</p>
                    </div>
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong>${{ number_format((float) $order->subtotal, 2) }}</strong>
                </div>

                <div class="summary-row">
                    <span>Discount</span>
                    <strong class="discount-value">
                        -${{ number_format((float) $order->discountamount, 2) }}
                    </strong>
                </div>

                <div class="summary-row">
                    <span>Shipping Fee</span>
                    <strong>${{ number_format((float) $order->shippingfee, 2) }}</strong>
                </div>

                <div class="summary-total">
                    <span>Total Amount</span>
                    <strong>${{ number_format((float) $order->totalamount, 2) }}</strong>
                </div>
            </div>

            {{-- Customer Card --}}
            <div class="details-card customer-card">
                <div class="card-heading">
                    <div>
                        <h3>Customer</h3>
                        <p>Customer account details</p>
                    </div>
                </div>

                @if($order->user)
                    <div class="customer-profile">
                        <div class="customer-avatar">
                            {{ strtoupper(substr($order->user->firstname, 0, 1)) }}
                        </div>

                        <div>
                            <strong>
                                {{ $order->user->firstname }}
                                {{ $order->user->lastname }}
                            </strong>

                            <span>Customer</span>
                        </div>
                    </div>

                    <div class="customer-contact">
                        <div>
                            <span>Email</span>
                            <strong>{{ $order->user->email }}</strong>
                        </div>

                        <div>
                            <span>Phone</span>
                            <strong>{{ $order->user->phone ?? 'N/A' }}</strong>
                        </div>
                    </div>
                @else
                    <p class="empty-message">Customer information unavailable.</p>
                @endif
            </div>

        </div>
    </div>

</div>

<style>
    .order-details-page {
        color: #202124;
        width: 100%;
    }

    .details-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .details-header h2 {
        font-size: 25px;
        margin: 8px 0 5px;
        font-weight: 700;
    }

    .details-header p {
        color: #777;
        font-size: 14px;
        margin: 0;
    }

    .breadcrumb {
        display: flex;
        gap: 9px;
        font-size: 12px;
        color: #999;
    }

    .breadcrumb a {
        color: #555;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        color: #000;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 11px 16px;
        background: white;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        color: #333;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        transition: .2s;
    }

    .back-button:hover {
        background: #171717;
        color: white;
    }

    .order-alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .order-alert.success {
        background: #eaf7ef;
        color: #237345;
        border: 1px solid #c8ead4;
    }

    .order-alert.error {
        background: #fff0f0;
        color: #b42318;
        border: 1px solid #f5cccc;
    }

    .overview-card,
    .details-card {
        background: #fff;
        border: 1px solid #ededed;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.025);
    }

    .overview-card {
        padding: 24px;
        margin-bottom: 22px;
    }

    .overview-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .section-label {
        color: #999;
        font-size: 10px;
        letter-spacing: 1.2px;
        font-weight: 700;
    }

    .overview-top h3 {
        margin: 8px 0;
        font-size: 21px;
        font-weight: 700;
    }

    .order-date {
        color: #888;
        font-size: 12px;
    }

    .overview-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
    }

    .status-badge,
    .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pending {
        background: #fff5df;
        color: #a66b00;
    }

    .status-processing {
        background: #eaf2ff;
        color: #2862b3;
    }

    .status-shipped {
        background: #f0eaff;
        color: #7044b7;
    }

    .status-delivered {
        background: #e6f6ed;
        color: #21834b;
    }

    .status-cancelled {
        background: #ffe9e9;
        color: #c03939;
    }

    .payment-badge {
        background: #f2f2f2;
        color: #555;
    }

    .overview-divider {
        height: 1px;
        background: #eee;
        margin: 22px 0;
    }

    .overview-bottom {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .overview-item {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .overview-item span {
        font-size: 12px;
        color: #888;
    }

    .overview-item strong {
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .overview-item .overview-total {
        font-size: 18px;
    }

    .details-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 330px;
        gap: 22px;
        align-items: start;
    }

    .details-main,
    .details-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
    }

    .details-card {
        padding: 22px;
    }

    .card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .card-heading h3 {
        font-size: 16px;
        margin: 0 0 5px;
        font-weight: 700;
    }

    .card-heading p {
        color: #999;
        font-size: 12px;
        margin: 0;
    }

    .item-count {
        padding: 6px 10px;
        border-radius: 6px;
        background: #f4f4f4;
        color: #555;
        font-size: 11px;
        white-space: nowrap;
    }

    .heading-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f4f4f4;
        color: #333;
        font-size: 19px;
    }

    .products-table-wrapper {
        overflow-x: auto;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        min-width: 550px;
    }

    .details-table th {
        background: #f8f8f8;
        color: #777;
        font-size: 11px;
        font-weight: 600;
        padding: 13px 12px;
        white-space: nowrap;
    }

    .details-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 12px;
        color: #555;
    }

    .product-name {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .product-name strong {
        color: #222;
        font-size: 12px;
    }

    .product-name small {
        color: #999;
        font-size: 10px;
    }

    .variant-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .quantity-badge {
        background: #f2f2f2;
        padding: 5px 9px;
        border-radius: 5px;
        font-weight: 600;
    }

    .price-cell {
        font-weight: 700;
        color: #222 !important;
    }

    .empty-row {
        text-align: center;
        padding: 30px !important;
        color: #999 !important;
    }

    .information-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .information-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .information-item span {
        font-size: 11px;
        color: #999;
        text-transform: capitalize;
    }

    .information-item strong {
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .empty-message {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 14px;
        background: #f8f8f8;
        border-radius: 7px;
        color: #888;
        font-size: 12px;
    }

    .status-card .current-status {
        display: flex;
        flex-direction: column;
        gap: 9px;
        margin-bottom: 20px;
    }

    .current-status > span {
        font-size: 11px;
        color: #999;
    }

    .current-status .status-badge {
        width: fit-content;
    }

    .status-card .form-group {
        margin-bottom: 15px;
    }

    .status-card label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .status-card select {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e2e2;
        border-radius: 7px;
        background: #fff;
        color: #333;
        font-size: 13px;
        outline: none;
    }

    .status-card select:focus {
        border-color: #555;
    }

    .update-status-button {
        width: 100%;
        padding: 13px;
        background: #171717;
        color: white;
        border: none;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .update-status-button:hover {
        background: #383838;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .summary-row span {
        color: #888;
        font-size: 12px;
    }

    .summary-row strong {
        font-size: 12px;
    }

    .discount-value {
        color: #239653;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding-top: 18px;
        margin-top: 5px;
    }

    .summary-total span {
        font-size: 13px;
        font-weight: 700;
    }

    .summary-total strong {
        font-size: 20px;
        font-weight: 700;
    }

    .customer-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .customer-avatar {
        width: 42px;
        height: 42px;
        background: #191919;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 16px;
        font-weight: 700;
    }

    .customer-profile > div:last-child {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .customer-profile strong {
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .customer-profile span {
        color: #999;
        font-size: 11px;
    }

    .customer-contact {
        display: flex;
        flex-direction: column;
        gap: 15px;
        border-top: 1px solid #eee;
        padding-top: 16px;
    }

    .customer-contact div {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .customer-contact span {
        color: #999;
        font-size: 11px;
    }

    .customer-contact strong {
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .payment-status-text {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
    }

    .payment-status-text.is-paid {
        color: #21834b;
    }

    .payment-status-text.is-pending {
        color: #a66b00;
    }

    .payment-action {
        margin-top: 22px;
        padding: 15px;
        background: #fafafa;
        border: 1px solid #ededed;
        border-radius: 8px;
    }

    .payment-action p {
        margin: 0 0 13px;
        color: #777;
        font-size: 12px;
        line-height: 1.6;
    }

    .mark-paid-button {
        width: 100%;
        padding: 12px 15px;
        border: 0;
        border-radius: 7px;
        background: #21834b;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .mark-paid-button:hover {
        background: #176638;
    }

    .payment-confirmed-message {
        margin-top: 20px;
        padding: 13px 15px;
        border: 1px solid #c8ead4;
        border-radius: 7px;
        background: #eaf7ef;
        color: #237345;
        font-size: 12px;
        font-weight: 600;
    }

    .notes-content {
        padding: 14px;
        background: #f8f8f8;
        border-radius: 7px;
        font-size: 13px;
        color: #555;
        line-height: 1.6;
    }

    @media (max-width: 1100px) {
        .details-layout {
            grid-template-columns: minmax(0, 1fr) 290px;
        }
    }

    @media (max-width: 850px) {
        .details-layout {
            grid-template-columns: 1fr;
        }

        .details-sidebar {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .details-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .overview-top {
            flex-direction: column;
        }

        .overview-bottom {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .information-grid {
            grid-template-columns: 1fr;
        }

        .details-sidebar {
            display: flex;
        }

        .overview-card,
        .details-card {
            padding: 17px;
        }
    }
</style>

@endsection
