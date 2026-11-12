<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('code', 'ILIKE', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('isactive', $request->status === 'active');
        }

        $coupons = $query
            ->withCount('usages')
            ->orderBy('createdat', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discounttype' => ['required', Rule::in(['percentage', 'fixed'])],
            'discountvalue' => ['required', 'numeric', 'min:0.01'],
            'minimumorderamount' => ['nullable', 'numeric', 'min:0'],
            'maximumdiscount' => ['nullable', 'numeric', 'min:0'],
            'usagelimit' => ['nullable', 'integer', 'min:1'],
            'startsat' => ['nullable', 'date'],
            'expiresat' => ['nullable', 'date', 'after_or_equal:startsat'],
            'isactive' => ['required', 'boolean'],
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));

        if (
            $validated['discounttype'] === 'percentage'
            && $validated['discountvalue'] > 100
        ) {
            return back()
                ->withErrors(['discountvalue' => 'Percentage cannot exceed 100.'])
                ->withInput();
        }

        Coupon::create($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($coupon->id),
            ],
            'discounttype' => ['required', Rule::in(['percentage', 'fixed'])],
            'discountvalue' => ['required', 'numeric', 'min:0.01'],
            'minimumorderamount' => ['nullable', 'numeric', 'min:0'],
            'maximumdiscount' => ['nullable', 'numeric', 'min:0'],
            'usagelimit' => ['nullable', 'integer', 'min:1'],
            'startsat' => ['nullable', 'date'],
            'expiresat' => ['nullable', 'date', 'after_or_equal:startsat'],
            'isactive' => ['required', 'boolean'],
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));

        if (
            $validated['discounttype'] === 'percentage'
            && $validated['discountvalue'] > 100
        ) {
            return back()
                ->withErrors(['discountvalue' => 'Percentage cannot exceed 100.'])
                ->withInput();
        }

        $coupon->update($validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        if ($coupon->usages()->exists()) {
            return back()->with(
                'error',
                'This coupon has already been used and cannot be deleted.'
            );
        }

        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}
