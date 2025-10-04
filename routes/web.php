<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\GoogleController;
use App\Livewire\Pages\Auth\Login as LoginPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::view('/', 'home')->name('home');

// Login (Livewire Page)
Route::get('/login', LoginPage::class)
    ->middleware('guest')
    ->name('login');

    Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // o route('home')
})->middleware('auth')->name('logout');
// Público (carrito)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Google OAuth
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('/redirect', [GoogleController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('callback');
});

Route::view('/', 'products')->name('home');

// Autenticados
Route::middleware('auth')->group(function () {
    // Perfil
    Route::view('/profile', 'profile')->name('profile');

    // Cliente
    Route::middleware('auth')->group(function () {
    Route::view('/mis-productos', 'products')->name('customer.products'); // ← antes decía 'customer.products'
    Route::view('/dashboard', 'dashboard')->middleware('can:admin')->name('dashboard');
});

    // Admin
    Route::view('/dashboard', 'dashboard')
        ->middleware('can:admin')
        ->name('dashboard');
});

// (Opcional) Diagnóstico: quién soy (solo en local/debug)
if (config('app.debug')) {
    Route::get('/whoami', function () {
        return auth()->check()
            ? 'OK: '.auth()->user()->email.' | rol='.auth()->user()->role
            : 'NO AUTH';
    })->middleware('auth')->name('whoami');
}

// Rutas Breeze (register, forgot-password, reset, verify-email, confirm-password, logout, etc.)
require __DIR__.'/auth.php';
