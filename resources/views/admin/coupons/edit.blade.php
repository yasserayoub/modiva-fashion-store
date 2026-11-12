
@extends('layouts.admin')

@section('content')
<div class="coupon-form-page">

    <div class="form-header">
        <div>
            <h1>Edit Coupon</h1>
            <p>Update coupon code and discount settings.</p>
        </div>

        <a href="{{ route('admin.coupons.index') }}" class="back-btn">
            ← Back to Coupons
        </a>
    </div>

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card">
            <h2>Coupon Information</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label>Coupon Code *</label>
                    <input type="text" name="code"
                           value="{{ old('code', $coupon->code) }}" required>
                    @error('code') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Discount Type *</label>
                    <select name="discounttype" required>
                        <option value="percentage"
                            {{ old('discounttype', $coupon->discounttype) === 'percentage' ? 'selected' : '' }}>
                            Percentage (%)
                        </option>
                        <option value="fixed"
                            {{ old('discounttype', $coupon->discounttype) === 'fixed' ? 'selected' : '' }}>
                            Fixed Amount ($)
                        </option>
                    </select>
                    @error('discounttype') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Discount Value *</label>
                    <input type="number" name="discountvalue"
                           value="{{ old('discountvalue', $coupon->discountvalue) }}"
                           min="0.01" step="0.01" required>
                    @error('discountvalue') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Minimum Order Amount ($)</label>
                    <input type="number" name="minimumorderamount"
                           value="{{ old('minimumorderamount', $coupon->minimumorderamount) }}"
                           min="0" step="0.01">
                    @error('minimumorderamount') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Maximum Discount ($)</label>
                    <input type="number" name="maximumdiscount"
                           value="{{ old('maximumdiscount', $coupon->maximumdiscount) }}"
                           min="0" step="0.01">
                    @error('maximumdiscount') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Usage Limit</label>
                    <input type="number" name="usagelimit"
                           value="{{ old('usagelimit', $coupon->usagelimit) }}"
                           min="1">
                    @error('usagelimit') <small>{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <div class="form-card">
            <h2>Validity Period</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="datetime-local" name="startsat"
                           value="{{ old('startsat', $coupon->startsat?->format('Y-m-d\TH:i')) }}">
                    @error('startsat') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Expiration Date</label>
                    <input type="datetime-local" name="expiresat"
                           value="{{ old('expiresat', $coupon->expiresat?->format('Y-m-d\TH:i')) }}">
                    @error('expiresat') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Coupon Status *</label>
                    <select name="isactive" required>
                        <option value="1"
                            {{ old('isactive', (int) $coupon->isactive) == 1 ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0"
                            {{ old('isactive', (int) $coupon->isactive) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('isactive') <small>{{ $message }}</small> @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.coupons.index') }}" class="cancel-btn">Cancel</a>
            <button type="submit" class="save-btn">Save Changes</button>
        </div>

    </form>
</div>

<style>
.coupon-form-page {
    max-width: 1000px;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.form-header h1 {
    margin: 0 0 7px;
    font-size: 25px;
    color: #222;
}

.form-header p {
    margin: 0;
    color: #888;
    font-size: 14px;
}

.back-btn {
    background: #eee;
    color: #333;
    padding: 10px 15px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
}

.form-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
}

.form-card h2 {
    font-size: 17px;
    margin: 0 0 22px;
    color: #222;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #444;
}

.form-group input,
.form-group select {
    width: 100%;
    box-sizing: border-box;
    padding: 11px 12px;
    border: 1px solid #ddd;
    border-radius: 7px;
    font-size: 13px;
    outline: none;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #555;
}

.form-group small {
    color: #c0392b;
    font-size: 12px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.cancel-btn,
.save-btn {
    padding: 11px 18px;
    border-radius: 7px;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
}

.cancel-btn {
    background: #eee;
    color: #444;
}

.save-btn {
    background: #222;
    color: white;
    border: none;
}

@media(max-width: 650px) {
    .form-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-card {
        padding: 18px;
    }
}
</style>
@endsection
