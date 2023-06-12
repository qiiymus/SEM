<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AnnouncementController;

// Change this to change the default page
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [AnnouncementController::class, 'index'])->name('announcement');
});

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
Route::get('/products', [ProductController::class, 'index'])->name('product');
Route::get('/products/add', [ProductController::class, 'create'])->name('addInventory');
Route::post('/products/store', [ProductController::class, 'store'])->name('storeInventory');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('editInventory');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('updateInventory');
Route::post('/products/delete/{id}', [ProductController::class, 'destroy'])->name('deleteInventory');

//Report Module
Route::get('/report', [ReportController::class, 'index'])->name('report')->middleware('role:admin');
Route::post('/report', [ReportController::class, 'index'])->name('report');
Route::get('report/data/{range}', [ReportController::class, 'getData'])->name('report.data');
Route::get('/report/export', [ReportController::class, 'exportCSV'])->name('csv');

// Announcement Module
Route::get('/dashboard', [AnnouncementController::class, 'index'])->name('announcement');
Route::get('/announcements/add', [AnnouncementController::class, 'create'])->name('addAnnouncement');
Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('storeAnnouncement');
Route::get('/announcements/edit/{id}', [AnnouncementController::class, 'edit'])->name('editAnnouncement');
Route::post('/announcements/update/{id}', [AnnouncementController::class, 'update'])->name('updateAnnouncement');
Route::post('/announcements/delete/{id}', [AnnouncementController::class, 'destroy'])->name('deleteAnnouncement');
Route::get('/announcementList', [AnnouncementController::class, 'announcementList'])->name('announcementList');

// User Module
Route::get('/users', [UserController::class, 'index'])->name('user');
Route::get('/users/add', [UserController::class, 'create'])->name('addUser');
Route::post('/users/store', [UserController::class, 'store'])->name('storeUser');
Route::get('/users/edit', [UserController::class, 'edit'])->name('editUser');
Route::post('/users/update', [UserController::class, 'update'])->name('updateUser');
Route::delete('/users/delete', [UserController::class, 'destroy'])->name('deleteUser');
