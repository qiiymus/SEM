<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/products', [ProductController::class, 'index'])->name('product');

// Payment
Route::get('/cart', [PaymentController::class, 'index'])->name('cart');
Route::post('/cart', [PaymentController::class, 'storeCart'])->name('cart.store');
Route::get('/cart/{id}', [PaymentController::class, 'destroyCart'])->name('cart.destroy');
Route::get('/cart/{id}/increment', [PaymentController::class, 'incrementQuantity'])->name('cart.plus');
Route::get('/cart/{id}/decrement', [PaymentController::class, 'decrementQuantity'])->name('cart.minus');
