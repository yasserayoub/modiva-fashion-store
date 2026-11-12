
@extends('layouts.admin')

@section('content')
<div class="coupons-page">

    <div class="coupons-header">
        <div>
            <h1>Coupon Management</h1>
            <p>Create and manage promotional discount codes.</p>
        </div>

        <a href="{{ route('admin.coupons.create') }}" class="add-coupon-btn">
            + Add Coupon
        </a>
    </div>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="coupons-card">

        <form method="GET" action="{{ route('admin.coupons.index') }}" class="filter-form">
            <input
                type="text"
                name="search"
                placeholder="Search coupon code..."
                value="{{ request('search') }}"
            >

            <select name="status">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            <button type="submit" class="filter-btn">Filter</button>

            <a href="{{ route('admin.coupons.index') }}" class="reset-btn">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="coupons-table">
                <thead>
                    <tr>
                        <th>Coupon Code</th>
                        <th>Discount</th>
                        <th>Minimum Order</th>
                        <th>Usage</th>
                        <th>Expiration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <strong class="coupon-code">{{ $coupon->code }}</strong>
                            </td>

                            <td>
                                @if($coupon->discounttype === 'percentage')
                                    {{ number_format($coupon->discountvalue, 2) }}%
                                @else
                                    ${{ number_format($coupon->discountvalue, 2) }}
                                @endif
                            </td>

                            <td>
                                ${{ number_format($coupon->minimumorderamount ?? 0, 2) }}
                            </td>

                            <td>
                                {{ $coupon->usages_count }}
                                /
                                {{ $coupon->usagelimit ?? 'Unlimited' }}
                            </td>

                            <td>
                                {{ $coupon->expiresat?->format('M d, Y') ?? 'No expiration' }}
                            </td>

                            <td>
                                <span class="{{ $coupon->isactive ? 'status-active' : 'status-inactive' }}">
                                    {{ $coupon->isactive ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                       class="edit-btn">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-message">
                                No coupons found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $coupons->links() }}
        </div>

    </div>
</div>

<style>
.coupons-page {
    max-width: 1400px;
}

.coupons-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.coupons-header h1 {
    margin: 0 0 7px;
    font-size: 25px;
    color: #222;
}

.coupons-header p {
    margin: 0;
    color: #888;
    font-size: 14px;
}

.add-coupon-btn {
    background: #222;
    color: white;
    text-decoration: none;
    padding: 11px 17px;
    border-radius: 7px;
    font-size: 13px;
}

.coupons-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 22px;
}

.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 22px;
}

.filter-form input,
.filter-form select {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 7px;
    font-size: 13px;
    min-width: 180px;
}

.filter-btn, .reset-btn {
    padding: 10px 16px;
    border: none;
    border-radius: 7px;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
}

.filter-btn {
    background: #222;
    color: white;
}

.reset-btn {
    background: #eee;
    color: #444;
}

.table-responsive {
    overflow-x: auto;
}

.coupons-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 850px;
}

.coupons-table th {
    background: #f8f8f8;
    color: #777;
    font-size: 11px;
    text-transform: uppercase;
    text-align: left;
    padding: 14px;
}

.coupons-table td {
    padding: 15px 14px;
    border-bottom: 1px solid #eee;
    font-size: 13px;
    color: #444;
}

.coupon-code {
    color: #222;
    letter-spacing: .5px;
}

.status-active, .status-inactive {
    display: inline-block;
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

.action-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
}

.edit-btn, .delete-btn {
    border: none;
    text-decoration: none;
    padding: 7px 11px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
}

.edit-btn {
    background: #eaf1ff;
    color: #315da8;
}

.delete-btn {
    background: #fff0f0;
    color: #c0392b;
}

.empty-message {
    text-align: center;
    padding: 30px !important;
    color: #888 !important;
}

.pagination-wrapper {
    margin-top: 20px;
}

.success-message, .error-message {
    padding: 12px 15px;
    border-radius: 7px;
    margin-bottom: 18px;
    font-size: 13px;
}

.success-message {
    background: #e8f7ee;
    color: #21864b;
}

.error-message {
    background: #fceaea;
    color: #c0392b;
}

@media(max-width: 650px) {
    .coupons-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .coupons-card {
        padding: 14px;
    }

    .filter-form {
        flex-direction: column;
    }

    .filter-form input,
    .filter-form select {
        width: 100%;
    }
}
</style>
@endsection
