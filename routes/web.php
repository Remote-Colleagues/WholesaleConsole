<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AdminController;

Route::get('/admin/register', [AdminController::class, 'create'])->name('admin.register.form');
Route::post('/admin/register', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');



use App\Http\Controllers\ConsolerController;

Route::get('/consolers/create', [ConsolerController::class, 'create'])->name('consolers.create');
Route::post('/consolers', [ConsolerController::class, 'store'])->name('consolers.store');
Route::get('consolers/{id}/details', [ConsolerController::class, 'viewConsolerDetails'])->name('consoler.details');
Route::get('/consolerslist', [AdminController::class, 'consolerList'])->name('consoler.list');



use App\Http\Controllers\Controller;
Route::get('register', [Controller::class, 'showRegistrationForm'])->name('register.form');

Route::post('register', [Controller::class, 'register'])->name('register');

Route::get('login', [Controller::class, 'showLoginForm'])->name('login.form');

Route::post('login', [Controller::class, 'login'])->name('login');

Route::post('logout', [Controller::class, 'logout'])->name('logout');

Route::get('admin/dashboard', function () {
    if (session('is_admin')) {
        return view('admin.dashboard');
    }

    return redirect()->route('login.form')->with('error', 'You are not authorized to access this page.');
})->name('admin.dashboard');

Route::get('consoler/dashboard', function () {
    if (session('is_consoler')) {
        return view('consoler.dashboard');
    }

    return redirect()->route('login.form')->with('error', 'You are not authorized to access this page.');
})->name('consoler.dashboard');

Route::get('partner/dashboard', function () {
    if (session('is_partner')) {
        return view('partner.dashboard');
    }

    return redirect()->route('login.form')->with('error', 'You are not authorized to access this page.');
})->name('partner.dashboard');



