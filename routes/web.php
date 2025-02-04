<?php

use App\Http\Controllers\CalculateController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsolerController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/register', [AdminController::class, 'create'])->name('admin.register.form');
Route::post('/admin/register', [AdminController::class, 'store'])->name('admin.store');
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile', [AdminController::class, 'show'])->name('admin.profile');
Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/edit/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::get('/consolerslist', [AdminController::class, 'consolerList'])->name('consoler.list');
Route::get('/auctions', [AdminController::class, 'showAllAuctions'])->name('auctions.index');
Route::post('/auctions/import', [AdminController::class, 'import'])->name('auctions.import');


Route::get('/consolers/create', [ConsolerController::class, 'create'])->name('consolers.create');
Route::post('/consolers', [ConsolerController::class, 'store'])->name('consolers.store');
Route::get('/consoler/edit/{id}', [ConsolerController::class, 'edit'])->name('consoler.edit');
Route::put('/consoler/update/{id}', [ConsolerController::class, 'update'])->name('consoler.update');
Route::get('/consoler/details/{id}', [ConsolerController::class, 'showdetail'])->name('consoler.profile');
Route::get('car-auctions', [ConsolerController::class, 'showAllAuctions'])->name('auctions.car');
Route::get('/all-consolers-invoices', [ConsolerController::class, 'showInvoices'])->name('invoices.show');
Route::get('/consoler/dashboard', [ConsolerController::class, 'Dashboard'])->name('consoler.dashboard');
Route::get('/consolers/{id}', [ConsolerController::class, 'show'])->name('consoler.details');
Route::get('/agreement/{id}', [ConsolerController::class, 'agreement'])->name('agreement.show');
Route::post('/agreement-submit/{id}', [ConsolerController::class, 'submit'])->name('agreement.submit');
Route::get('/view-agreement-pdf/{userId}/{agreement}', [ConsolerController::class, 'viewAgreementPdf'])->name('view.agreement.pdf');

Route::post('/update-status', [Controller::class, 'updateStatus']);

Route::get('policy', [Controller::class, 'showPolicy'])->name('policy.form');
Route::get('login', [Controller::class, 'showLoginForm'])->name('login.form');
Route::post('login', [Controller::class, 'login'])->name('login');
Route::post('logout', [Controller::class, 'logout'])->name('logout');


Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/pdf/{id}', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');
Route::put('invoices/{id}/update-status', [InvoiceController::class, 'updateInvoiceStatus'])->name('invoices.updateStatus');
Route::get('/invoices/{id}/content', [InvoiceController::class, 'getInvoiceContent'])->name('invoices.content');
Route::get('/invoices/{id}/partner', [InvoiceController::class, 'partnerinvoice'])->name('invoices.partner');
Route::get('/invoices/partner/pdf/{id}', [InvoiceController::class, 'partnerPDF'])->name('partnerinvoices.pdf');
Route::get('/invoices/filter', [InvoiceController::class, 'filter'])->name('invoices.fill');


Route::get('/partnerlist', [PartnerController::class, 'partnerList'])->name('partner.list');
Route::get('partners/create', [PartnerController::class, 'create'])->name('partners.create');
Route::post('partners/store', [PartnerController::class, 'store'])->name('partners.store');
Route::get('/partners/{id}', [PartnerController::class, 'show'])->name('partner.details');
Route::get('/partner/edit/{id}', [PartnerController::class, 'edit'])->name('partner.edit');
Route::put('/partner/update/{id}', [PartnerController::class, 'update'])->name('partner.update');
Route::get('/partner/details/{id}', [PartnerController::class, 'showdetail'])->name('partner.profile');
Route::get('/partner/dashboard', [PartnerController::class, 'Dashboard'])->name('partner.dashboard');
Route::get('car-auctions/part', [PartnerController::class, 'showAllAuctions'])->name('auction.car');
Route::get('/agreement/{id}', [PartnerController::class, 'agreement'])->name('partneragreement.show');
Route::post('/agreement-submit/{id}', [PartnerController::class, 'submit'])->name('partneragreement.submit');
Route::get('/view-partneragreement-pdf/{userId}/{agreement}', [PartnerController::class, 'viewAgreementPdf'])->name('view.partneragreement.pdf');
Route::get('/all-partners-invoices', [PartnerController::class, 'showInvoices'])->name('invoicepartner.show');

Route::get('/calculatelist', [CalculateController::class, 'calculatelist'])->name('calculate.list');
Route::get('calculate/create', [CalculateController::class, 'create'])->name('calculate.create');
Route::post('calculate/store', [CalculateController::class, 'store'])->name('calculate.store');
Route::get('/calculate/{id}', [CalculateController::class, 'show'])->name('calculate.details');
Route::get('/calculate/edit/{id}', [CalculateController::class, 'edit'])->name('calculate.edit');
Route::put('/calculate/update/{id}', [CalculateController::class, 'update'])->name('calculate.update');
Route::delete('/calculate/{id}', [CalculateController::class, 'destroy'])->name('calculate.destroy');
Route::get('/get-transport-cost/{carId}', [CalculateController::class, 'getTransportCost']);

