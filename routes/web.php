<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceModelController;
use App\Http\Controllers\RetirementController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

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
    Route::get('/attendance/{token}', 'store');
});

Route::controller(RetirementController::class)->group(function () {
    Route::get('/retirement/{token}', 'store');
});

Route::get('/two-factor-register', [UserProfileController::class, 'show'])
->name('two-factor-register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    '2fa-verified'
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

    Route::get('/database', function () {
        return view('database');
    })->name('database');
});

Route::get('/open-account/{invitation}', [Controller::class, 'accept'])
->middleware(['signed'])
->name('open-account.accept');
