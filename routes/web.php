<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AdminController;

Route::get('/admin/register', [AdminController::class, 'create'])->name('admin.register.form');
Route::post('/admin/register', [AdminController::class, 'store'])->name('admin.store');
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile', [AdminController::class, 'show'])->name('admin.profile');
Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/edit/{id}', [AdminController::class, 'update'])->name('admin.update');


use App\Http\Controllers\ConsolerController;

Route::get('/consolers/create', [ConsolerController::class, 'create'])->name('consolers.create');
Route::post('/consolers', [ConsolerController::class, 'store'])->name('consolers.store');
Route::get('/consoler/edit/{id}', [ConsolerController::class, 'edit'])->name('consoler.edit');
Route::put('/consoler/update/{id}', [ConsolerController::class, 'update'])->name('consoler.update');
Route::get('/consoler/details/{id}', [ConsolerController::class, 'showdetail'])->name('consoler.profile');
Route::get('car-auctions', [ConsolerController::class, 'showAllAuctions'])->name('auctions.car');
Route::get('/all-consolers-invoices', [ConsolerController::class, 'showInvoices'])->name('invoices.show');

Route::get('/consoler/dashboard', [ConsolerController::class, 'Dashboard'])->name('consoler.dashboard');


Route::get('/consolers/{id}', [ConsolerController::class, 'show'])->name('consoler.details');
Route::get('/consolerslist', [AdminController::class, 'consolerList'])->name('consoler.list');
Route::get('/auctions', [AdminController::class, 'showAllAuctions'])->name('auctions.index');

 Route::post('/auctions/import', [AdminController::class, 'import'])->name('auctions.import');

Route::post('/update-status', [Controller::class, 'updateStatus']);


use App\Http\Controllers\Controller;
Route::get('policy', [Controller::class, 'showPolicy'])->name('policy.form');

Route::get('login', [Controller::class, 'showLoginForm'])->name('login.form');

Route::post('login', [Controller::class, 'login'])->name('login');

Route::post('logout', [Controller::class, 'logout'])->name('logout');

Route::get('partner/dashboard', function () {
    if (session('is_partner')) {
        return view('partner.dashboard');
    }

    return redirect()->route('login.form')->with('error', 'You are not authorized to access this page.');
})->name('partner.dashboard');

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

Route::get('/invoices/pdf/{id}', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');
Route::put('invoices/{id}/update-status', [InvoiceController::class, 'updateInvoiceStatus'])->name('invoices.updateStatus');

Route::get('/invoices/{id}/content', [InvoiceController::class, 'getInvoiceContent'])->name('invoices.content');
Route::get('/invoices/filter', [InvoiceController::class, 'filter'])->name('invoices.fill');


Route::get('/auctions/{id}/edit', [AdminController::class, 'editAuction'])->name('auctions.edit');
Route::put('/auctions/{id}', [AdminController::class, 'updateAuction'])->name('auctions.update');
