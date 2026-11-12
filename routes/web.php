
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CheckoutController;


// Public pages


Route::get('/', [StorefrontController::class, 'index'])->name('home');

// Guest Checkout
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

//guest cart
Route::post('/cart/add', [CheckoutController::class, 'addToCart'])
    ->name('cart.add');

Route::patch('/cart/update', [CheckoutController::class, 'updateCart'])
    ->name('cart.update');

Route::delete('/cart/remove', [CheckoutController::class, 'removeFromCart'])
    ->name('cart.remove');

    Route::get('/cart', [CheckoutController::class, 'getCart'])
    ->name('cart.get');

    Route::post('/cart/apply-coupon', [CheckoutController::class, 'applyCoupon'])
    ->name('cart.applyCoupon');


// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
//admin routes

Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Products
        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');
            // Categories
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create');

Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store');
    // Brands
Route::get('/brands', [BrandController::class, 'index'])
    ->name('brands.index');

Route::get('/brands/create', [BrandController::class, 'create'])
    ->name('brands.create');

Route::post('/brands', [BrandController::class, 'store'])
    ->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])
    ->name('brands.edit');

Route::put('/brands/{brand}', [BrandController::class, 'update'])
    ->name('brands.update');

Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])
    ->name('brands.destroy');
    // Category editing and deletion
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
    ->name('categories.edit');

Route::put('/categories/{category}', [CategoryController::class, 'update'])
    ->name('categories.update');

Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');

    // Products
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store');

Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

Route::put('/products/{product}', [ProductController::class, 'update'])
    ->name('products.update');

Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy');
    // Product Variants
Route::get('/products/{product}/variants',
    [ProductVariantController::class, 'index'])
    ->name('variants.index');

Route::get('/products/{product}/variants/create',
    [ProductVariantController::class, 'create'])
    ->name('variants.create');

Route::post('/products/{product}/variants',
    [ProductVariantController::class, 'store'])
    ->name('variants.store');

Route::get('/products/{product}/variants/{variant}/edit',
    [ProductVariantController::class, 'edit'])
    ->name('variants.edit');

Route::put('/products/{product}/variants/{variant}',
    [ProductVariantController::class, 'update'])
    ->name('variants.update');

Route::delete('/products/{product}/variants/{variant}',
    [ProductVariantController::class, 'destroy'])
    ->name('variants.destroy');
    // Size Management
Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');
Route::put('/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');
Route::delete('/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');

// Color Management
Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
Route::put('/colors/{color}', [ColorController::class, 'update'])->name('colors.update');
Route::delete('/colors/{color}', [ColorController::class, 'destroy'])->name('colors.destroy');
// Inventory Management
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');

// Order Management
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.updateStatus');
    Route::put('/orders/{order}/payment/mark-paid', [OrderController::class, 'markAsPaid'])
    ->name('orders.markAsPaid');

    Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])
    ->name('customers.show');
    // Coupon Management
Route::get('/coupons', [CouponController::class, 'index'])
    ->name('coupons.index');

Route::get('/coupons/create', [CouponController::class, 'create'])
    ->name('coupons.create');

Route::post('/coupons', [CouponController::class, 'store'])
    ->name('coupons.store');

Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])
    ->name('coupons.edit');

Route::put('/coupons/{coupon}', [CouponController::class, 'update'])
    ->name('coupons.update');

Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])
    ->name('coupons.destroy');
});


