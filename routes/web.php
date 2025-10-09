<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Pages\Auth\Login as LoginPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* =========================
|  PÚBLICO
========================= */

// Home (usa el controlador; elimina la Route::view duplicada)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/ubicanos', 'ubicanos')->name('ubicanos');


// Carrito (SESIÓN, sin login, sin parámetros)
Route::middleware(['web'])->prefix('cart')->name('cart.')->group(function () {
    Route::get('/',           [CartController::class, 'index'])->name('index');   // GET    /cart
    Route::post('/add',       [CartController::class, 'add'])->name('add');       // POST   /cart/add
    Route::patch('/{rowId}',  [CartController::class, 'update'])->name('update'); // PATCH  /cart/{rowId}
    Route::delete('/{rowId}', [CartController::class, 'remove'])->name('remove'); // DELETE /cart/{rowId}
    Route::delete('/',        [CartController::class, 'clear'])->name('clear');   // DELETE /cart
});

// (Opcional) Si ya tienes checkout, descomenta y crea la vista/controlador
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// Auth Google
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('/redirect',  [GoogleController::class, 'redirect'])->name('redirect');
    Route::get('/callback',  [GoogleController::class, 'callback'])->name('callback');
});

// Login (Livewire Page)
Route::get('/login', LoginPage::class)->middleware('guest')->name('login');

// Logout (POST)
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');


/* =========================
|  CLIENTE AUTENTICADO
========================= */
Route::middleware('auth')->group(function () {
    Route::view('/profile', 'profile')->name('profile');
    Route::view('/mis-productos', 'products')->name('customer.products');

    // Wishlist protegida
    Route::get('/wishlist',                          [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{productId}',         [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}',    [WishlistController::class, 'destroy'])->name('wishlist.remove');
});


/* =========================
|  ADMIN
========================= */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth','admin'])
    ->name('dashboard');

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('brands',     BrandController::class)->except(['show']);
    Route::resource('products',   ProductController::class)->except(['show']);
    Route::resource('users',      UserController::class)->except(['show']);
});

/*
 * ⚠️ Tenías recursos públicos para brands/products/users fuera de /admin.
 * Si realmente necesitas exponerlos públicamente, vuelve a activarlos; por defecto los quito
 * para evitar duplicados o fugas de rutas de administración.
 */
// Route::resource('brands', BrandController::class)->except(['show']);
// Route::resource('products', ProductController::class)->except(['show']);
// Route::resource('users', UserController::class)->except(['show', 'create', 'store']);


/* =========================
|  DIAGNÓSTICO (solo debug)
========================= */
if (config('app.debug')) {
    Route::get('/whoami', function () {
        return auth()->check()
            ? 'OK: ' . auth()->user()->email . ' | rol=' . auth()->user()->role
            : 'NO AUTH';
    })->middleware('auth')->name('whoami');
}


/* =========================
|  Auth scaffolding (Breeze/Fortify)
========================= */
require __DIR__ . '/auth.php';
