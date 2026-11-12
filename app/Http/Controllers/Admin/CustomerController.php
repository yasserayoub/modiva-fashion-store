<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('roleid', 2)
            ->withCount('orders');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'ILIKE', "%{$search}%")
                    ->orWhere('lastname', 'ILIKE', "%{$search}%")
                    ->orWhere('email', 'ILIKE', "%{$search}%")
                    ->orWhere('phone', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('isactive', $request->status === 'active');
        }

        $customers = $query
            ->orderBy('createdat', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }
    public function show(User $customer)
{
    if ($customer->roleid != 2) {
        abort(404);
    }

    $customer->load([
        'orders.orderItems.productVariant.product',
        'addresses'
    ]);

    return view('admin.customers.show', compact('customer'));
}
}
