
@extends('layouts.admin')

@section('page-heading', 'Customer Management')

@section('content')

<div class="customers-page">

    <div class="customers-header">
        <div>
            <h2>Customers</h2>
            <p>Manage and view your registered customers.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <div class="customers-card">

        <form action="{{ route('admin.customers.index') }}" method="GET" class="filters-form">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name, email or phone..."
            >

            <select name="status">
                <option value="">All Customers</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            <button type="submit">Search</button>

            <a href="{{ route('admin.customers.index') }}">Reset</a>

        </form>

        <div class="customers-table-wrapper">
            <table class="customers-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Orders</th>
                        <th>Status</th>
                        <th>Registered</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>
                                <div class="customer-name">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($customer->firstname, 0, 1)) }}
                                    </div>

                                    <strong>
                                        {{ $customer->firstname }}
                                        {{ $customer->lastname }}
                                    </strong>
                                </div>
                            </td>

                            <td>{{ $customer->email }}</td>

                            <td>{{ $customer->phone ?? 'N/A' }}</td>

                            <td>
                                <span class="orders-count">
                                    {{ $customer->orders_count }}
                                </span>
                            </td>

                            <td>
                                <span class="customer-status {{ $customer->isactive ? 'active' : 'inactive' }}">
                                    {{ $customer->isactive ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
    <a href="{{ route('admin.customers.show', $customer->id) }}"
       class="edit-btn">
        View
    </a>
</td>

                            <td>
                                {{ $customer->createdat?->format('d M Y') ?? 'N/A' }}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="empty-row">
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="customers-pagination">
            {{ $customers->links() }}
        </div>

    </div>
</div>

<style>
    .customers-page {
        width: 100%;
        color: #202124;
    }

    .customers-header {
        margin-bottom: 25px;
    }

    .customers-header h2 {
        font-size: 25px;
        margin: 0 0 6px;
        font-weight: 700;
    }

    .customers-header p {
        color: #888;
        font-size: 13px;
        margin: 0;
    }

    .customers-card {
        background: #fff;
        border: 1px solid #ededed;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0,0,0,.025);
    }

    .filters-form {
        display: flex;
        gap: 10px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .filters-form input,
    .filters-form select {
        padding: 11px 13px;
        border: 1px solid #e5e5e5;
        border-radius: 7px;
        font-size: 12px;
        outline: none;
    }

    .filters-form input {
        flex: 1;
        min-width: 200px;
    }

    .filters-form select {
        min-width: 145px;
        background: white;
    }

    .filters-form button {
        background: #171717;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 0 20px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
    }

    .filters-form a {
        display: flex;
        align-items: center;
        padding: 0 14px;
        color: #555;
        font-size: 12px;
        text-decoration: none;
    }

    .customers-table-wrapper {
        overflow-x: auto;
    }

    .customers-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
        text-align: left;
    }

    .customers-table th {
        background: #f8f8f8;
        padding: 14px;
        color: #777;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .customers-table td {
        padding: 15px 14px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 12px;
        color: #555;
    }

    .customer-name {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #222;
        white-space: nowrap;
    }

    .customer-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #191919;
        color: white;
        font-weight: 700;
    }

    .orders-count {
        background: #f2f2f2;
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 600;
    }

    .customer-status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .customer-status.active {
        background: #e6f6ed;
        color: #21834b;
    }

    .customer-status.inactive {
        background: #ffe9e9;
        color: #c03939;
    }

    .empty-row {
        text-align: center;
        padding: 35px !important;
        color: #999 !important;
    }

    .customers-pagination {
        margin-top: 20px;
    }

    @media(max-width: 600px) {
        .customers-card {
            padding: 15px;
        }

        .filters-form {
            flex-direction: column;
        }

        .filters-form input,
        .filters-form select,
        .filters-form button {
            width: 100%;
            min-height: 42px;
        }
    }
</style>

@endsection
