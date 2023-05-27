<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

// Duty Roster  Module
Route::get('/DutyRoster/add', [DutyRosterController::class, 'create'])->name('addDuty');
Route::post('/DutyRoster/store', [DutyRosterController::class, 'store'])->name('storeDuty');
Route::get('/DutyRoster/edit/{id}', [DutyRosterController::class, 'edit'])->name('editDuty');
Route::post('/DutyRoster/update/{id}', [DutyRosterController::class, 'update'])->name('updateDuty');
Route::post('/DutyRoster/delete/{id}', [DutyRosterController::class, 'destroy'])->name('deleteDuty');

