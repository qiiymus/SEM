<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/products/add', [ProductController::class, 'create'])->name('addInventory');
Route::post('/products/store', [ProductController::class, 'store'])->name('storeInventory');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('editInventory');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('updateInventory');
Route::post('/products/delete/{id}', [ProductController::class, 'destroy'])->name('deleteInventory');
