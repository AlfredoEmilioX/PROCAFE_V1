<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// PÚBLICO / BASE
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\GoogleController;

// CLIENTE AUTENTICADO
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;

// CHECKOUT DEMO
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentDemoController;

// ADMIN CRUD
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController     as AdminBrandController;
use App\Http\Controllers\Admin\ProductController   as AdminProductController;
use App\Http\Controllers\Admin\UserController      as AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
// PayU
use App\Http\Controllers\PayUController;

// ===== Route Model Binding seguro para PKs personalizadas =====
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

Route::bind('brand', function ($value) {
    return Brand::where('brand_id', $value)->firstOrFail();
});
Route::bind('category', function ($value) {
    return Category::where('category_id', $value)->firstOrFail();
});
Route::bind('product', function ($value) {
    return Product::where('product_id', $value)->firstOrFail();
});

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/ubicanos', 'ubicanos')->name('ubicanos');

// Carrito (por sesión)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',           [CartController::class, 'index'])->name('index');
    Route::post('/add',       [CartController::class, 'add'])->name('add');
    Route::patch('/{rowId}',  [CartController::class, 'update'])->name('update');
    Route::delete('/{rowId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/',        [CartController::class, 'clear'])->name('clear');
});

// Login/Register (Livewire)
// Login y Registro (vistas Blade)
Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');

// Google OAuth
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('/redirect', [GoogleController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('callback');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS (CLIENTE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/cliente', [CustomerDashboard::class, 'index'])->name('customer.dashboard');

    Route::view('/profile', 'profile')->name('profile');
    Route::view('/mis-productos', 'products')->name('customer.products');

    // Wishlist
    Route::get('/wishlist',                       [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{productId}',      [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

    // Checkout DEMO
    Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Simulación pagos
    Route::get('/payments/redirect', [PaymentDemoController::class, 'redirect'])->name('payments.redirect');
    Route::get('/payments/response', [PaymentDemoController::class, 'response'])->name('payments.response');
});

/*
|--------------------------------------------------------------------------
| ADMIN (requiere middleware 'admin' en Kernel)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD clásicos
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('brands',     AdminBrandController::class)->except(['show']);
    Route::resource('products',   AdminProductController::class)->except(['show']);
    Route::resource('users',      AdminUserController::class)->except(['show']);
});

// Alias opcional (compatibilidad): /dashboard → admin.dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| DIAGNÓSTICO (solo debug)
|--------------------------------------------------------------------------
*/
if (config('app.debug')) {
    Route::get('/whoami', function () {
        return auth()->check()
            ? 'OK: ' . auth()->user()->email . ' | rol=' . (auth()->user()->role ?? '—')
            : 'NO AUTH';
    })->middleware('auth')->name('whoami');
}
Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');

/*
|--------------------------------------------------------------------------
| PayU (separado del checkout demo)
|--------------------------------------------------------------------------
*/
Route::prefix('payu')->name('payu.')->group(function () {
    Route::get('/form',          [PayUController::class, 'showForm'])->name('form');
    Route::post('/checkout',     [PayUController::class, 'redirectToPayU'])->name('checkout');
    Route::post('/confirmation', [PayUController::class, 'confirmation'])->name('confirmation');
    Route::get('/response',      [PayUController::class, 'response'])->name('response');
});

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('brands',     AdminBrandController::class)->except(['show']);
    Route::resource('products',   AdminProductController::class)->except(['show']);
    Route::resource('users',      AdminUserController::class)->except(['show']);

    // === REPORTES ===
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/revenue.csv',      [ReportController::class, 'revenueCsv'])->name('revenue');
        Route::get('/best-sellers.csv', [ReportController::class, 'bestSellersCsv'])->name('best');
        Route::get('/products.csv',     [ReportController::class, 'productsCsv'])->name('products');
        Route::get('/orders.csv',       [ReportController::class, 'ordersCsv'])->name('orders');
    });
});
// routes/web.php
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');




// Auth scaffolding (Breeze/Fortify)
require __DIR__ . '/auth.php';
