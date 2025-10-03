<?php 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\CartController;
Route::view('/', 'home'); 
Route::view('dashboard', 'dashboard') ->middleware(['auth', 'verified']) ->name('dashboard'); 
Route::view('profile', 'profile') ->middleware(['auth']) ->name('profile'); 
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
require __DIR__.'/auth.php';