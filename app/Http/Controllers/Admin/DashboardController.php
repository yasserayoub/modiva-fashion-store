<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard statistics
        $totalProducts = Product::count();

        $totalOrders = Order::count();

        $totalCustomers = User::where('roleid', 2)->count();

        $totalOrderValue = Order::sum('totalamount');

        // Latest 5 orders
        $recentOrders = Order::with('user')
            ->latest('createdat')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalOrderValue',
            'recentOrders'
        ));
    }
}
