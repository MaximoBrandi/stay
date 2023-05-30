<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceModelController;
use App\Http\Controllers\RetirementController;

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

Route::controller(AttendanceModelController::class)->group(function () {
    Route::get('/attendance', 'store');
});

Route::controller(RetirementController::class)->group(function () {
    Route::get('/retirement', 'store');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/attendance', function () {
        return view('attendance');
    })->name('attendance');

    Route::get('/retirement', function () {
        return view('retirement');
    })->name('retirement');
});
