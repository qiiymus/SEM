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

// Payment Module
// Cart
Route::get('/cart', [PaymentController::class, 'index'])->name('cart');
Route::post('/cart', [PaymentController::class, 'storeCart'])->name('cart.store');
Route::delete('/cart/{id}', [PaymentController::class, 'destroyCart'])->name('cart.destroy');
Route::post('/cart/clear', [PaymentController::class, 'destroyAll'])->name('cart.destroyAll');
Route::get('/cart/{id}/increment', [PaymentController::class, 'incrementQuantity'])->name('cart.plus');
Route::get('/cart/{id}/decrement', [PaymentController::class, 'decrementQuantity'])->name('cart.minus');
// Payment
Route::get('/cart/checkout', [PaymentController::class, 'paymentIndex'])->name('payment.pay');
Route::post('/cart/checkout', [PaymentController::class, 'storePayment'])->name('payment.store');
// Change
Route::get('/change/{payment}', [PaymentController::class, 'changeIndex'])->name('payment.change');

// Inventory Module
Route::get('/products/add', [ProductController::class, 'create'])->name('addInventory');
Route::post('/products/store', [ProductController::class, 'store'])->name('storeInventory');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('editInventory');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('updateInventory');
Route::post('/products/delete/{id}', [ProductController::class, 'destroy'])->name('deleteInventory');
