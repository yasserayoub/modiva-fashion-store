
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')

    <div class="dashboard-welcome">
        <h2>Dashboard Overview</h2>
        <p>Here's what's happening with your store.</p>
    </div>

    <!-- Statistics -->
    <div class="dashboard-stats">

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Products</p>
                <h2>{{ number_format($totalProducts) }}</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Orders</p>
                <h2>{{ number_format($totalOrders) }}</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Customers</p>
                <h2>{{ number_format($totalCustomers) }}</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Order Value</p>
                <h2>${{ number_format((float) $totalOrderValue, 2) }}</h2>
            </div>
        </div>

    </div>
    <!-- Statistics END -->

    <!-- Recent Orders OUTSIDE the statistics grid -->
    <div class="recent-orders">

        <div class="section-header">
            <h3>Recent Orders</h3>
            <span>Latest 5 orders</span>
        </div>

        <div class="table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->ordernumber }}</td>
                            <td>
                                {{ $order->user
                                    ? $order->user->firstname . ' ' . $order->user->lastname
                                    : 'Unknown Customer' }}
                            </td>
                            <td>{{ $order->createdat->format('d M Y') }}</td>
                            <td>${{ number_format((float) $order->totalamount, 2) }}</td>
                            <td>{{ ucfirst($order->paymentstatus) }}</td>
                            <td>{{ ucfirst($order->orderstatus) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-orders">
                                No orders have been placed yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
