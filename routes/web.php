<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DefinitionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ComplaintController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Order Routes
Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
Route::get('/orders/pending/details', [OrderController::class, 'pendingDetails'])->name('orders.pending.details');
Route::get('/orders/pending/export', [OrderController::class, 'exportPending'])->name('orders.pending.export');
Route::get('/orders/pending/details/export', [OrderController::class, 'exportPendingDetails'])->name('orders.pending.details.export');

Route::get('/orders/approved', [OrderController::class, 'approved'])->name('orders.approved');
Route::get('/orders/approved/details', [OrderController::class, 'approvedDetails'])->name('orders.approved.details');
Route::get('/orders/approved/export', [OrderController::class, 'exportApproved'])->name('orders.approved.export');
Route::get('/orders/approved/details/export', [OrderController::class, 'exportApprovedDetails'])->name('orders.approved.details.export');

Route::get('/orders/cancelled', [OrderController::class, 'cancelled'])->name('orders.cancelled');
Route::get('/orders/cancelled/details', [OrderController::class, 'cancelledDetails'])->name('orders.cancelled.details');
Route::get('/orders/cancelled/export', [OrderController::class, 'exportCancelled'])->name('orders.cancelled.export');
Route::get('/orders/cancelled/details/export', [OrderController::class, 'exportCancelledDetails'])->name('orders.cancelled.details.export');

// Dealer Routes
Route::get('/dealers', [DealerController::class, 'index'])->name('dealers.index');
Route::get('/dealers/create', [DealerController::class, 'create'])->name('dealers.create');
Route::get('/dealers/export', [DealerController::class, 'exportExcel'])->name('dealers.export');
Route::post('/dealers', [DealerController::class, 'store'])->name('dealers.store');
Route::get('/dealers/{id}/edit', [DealerController::class, 'edit'])->name('dealers.edit');
Route::put('/dealers/{id}', [DealerController::class, 'update'])->name('dealers.update');
Route::delete('/dealers/{id}', [DealerController::class, 'destroy'])->name('dealers.destroy');

// Super Dealer Routes
Route::get('/super-dealers', [DealerController::class, 'superDealers'])->name('dealers.super-dealers');
Route::get('/dealers/{id}/make-super-dealer', [DealerController::class, 'makeSuperDealer'])->name('dealers.make-super-dealer');
Route::get('/dealers/{id}/remove-super-dealer', [DealerController::class, 'removeSuperDealer'])->name('dealers.remove-super-dealer');

// Mesajlar Modülü Routes
Route::prefix('messages')->name('messages.')->group(function () {
    Route::get('/create', [MessageController::class, 'create'])->name('create');
    Route::post('/', [MessageController::class, 'store'])->name('store');
    Route::get('/inbox', [MessageController::class, 'inbox'])->name('inbox');
    Route::get('/sent', [MessageController::class, 'sent'])->name('sent');
    Route::post('/{message}/read', [MessageController::class, 'markAsRead'])->name('read');
    Route::get('/{message}', [MessageController::class, 'show'])->name('show');
    Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
});

// Şikayetler Modülü Routes
Route::prefix('complaints')->name('complaints.')->group(function () {
    Route::get('/create', [ComplaintController::class, 'create'])->name('create');
    Route::post('/', [ComplaintController::class, 'store'])->name('store');
    Route::get('/inbox', [ComplaintController::class, 'inbox'])->name('inbox');
    Route::get('/sent', [ComplaintController::class, 'sent'])->name('sent');
    Route::post('/{complaint}/read', [ComplaintController::class, 'markAsRead'])->name('read');
    Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
    Route::put('/{complaint}', [ComplaintController::class, 'update'])->name('update');
    Route::delete('/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy');
});

// Tanımlar Routes
Route::prefix('definitions')->name('definitions.')->group(function () {
    // Bölümler
    Route::get('/sections', [DefinitionController::class, 'sections'])->name('sections');
    Route::post('/sections', [DefinitionController::class, 'storeSection'])->name('sections.store');
    Route::put('/sections/{section}', [DefinitionController::class, 'updateSection']);
    Route::delete('/sections/{section}', [DefinitionController::class, 'deleteSection']);

    // Kategoriler
    Route::get('/categories', [DefinitionController::class, 'categories'])->name('categories');
    Route::post('/categories', [DefinitionController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [DefinitionController::class, 'updateCategory']);
    Route::delete('/categories/{category}', [DefinitionController::class, 'deleteCategory']);

    // Slaytlar
    Route::get('/slides', [DefinitionController::class, 'slides'])->name('slides');
    Route::post('/slides', [DefinitionController::class, 'storeSlide'])->name('slides.store');
    Route::put('/slides/{slide}', [DefinitionController::class, 'updateSlide']);
    Route::delete('/slides/{slide}', [DefinitionController::class, 'deleteSlide']);

    // İçerikler
    Route::get('/contents', [DefinitionController::class, 'contents'])->name('contents');
    Route::post('/contents', [DefinitionController::class, 'storeContent'])->name('contents.store');
    Route::put('/contents/{content}', [DefinitionController::class, 'updateContent']);
    Route::delete('/contents/{content}', [DefinitionController::class, 'deleteContent']);
    Route::get('/contents-list', [DefinitionController::class, 'contentsList'])->name('contents.list');

    // İndirim Kodları
    Route::get('/discount-codes', [DefinitionController::class, 'discountCodes'])->name('discount-codes');
    Route::post('/discount-codes', [DefinitionController::class, 'storeDiscountCode'])->name('discount-codes.store');
    Route::put('/discount-codes/{discountCode}', [DefinitionController::class, 'updateDiscountCode']);
    Route::delete('/discount-codes/{discountCode}', [DefinitionController::class, 'deleteDiscountCode']);

    // İndirim Tipleri
    Route::get('/discount-types', [DefinitionController::class, 'discountTypes'])->name('discount-types');
    Route::post('/discount-types', [DefinitionController::class, 'storeDiscountType'])->name('discount-types.store');
    Route::put('/discount-types/{discountType}', [DefinitionController::class, 'updateDiscountType']);
    Route::delete('/discount-types/{discountType}', [DefinitionController::class, 'deleteDiscountType']);
    Route::get('/discount-types-list', [DefinitionController::class, 'discountTypesList'])->name('discount-types.list');

    // Veri Transfer İşlemleri
    Route::get('/transfer', [DefinitionController::class, 'transfer'])->name('transfer');
    Route::post('/transfer', [DefinitionController::class, 'startTransfer'])->name('transfer.start');
    
    // Dosya İçe Aktarma
    Route::get('/file-import', [DefinitionController::class, 'fileImport'])->name('file-import');
    Route::post('/file-import', [DefinitionController::class, 'startFileImport'])->name('file-import.start');
    
    // Resim Yükleme
    Route::get('/photo-upload', [DefinitionController::class, 'photoUpload'])->name('photo-upload');
    Route::post('/photo-upload', [DefinitionController::class, 'uploadPhoto'])->name('photo-upload.start');
});

// Raporlar Modülü Routes
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/summary', [ReportController::class, 'summary'])->name('summary');
    Route::get('/logs', [ReportController::class, 'logs'])->name('logs');
    Route::get('/dealers', [ReportController::class, 'dealers'])->name('dealers');
    Route::get('/daily-dealer-sales', [ReportController::class, 'dailyDealerSales'])->name('daily-dealer-sales');
    Route::get('/yearly-dealer-sales', [ReportController::class, 'yearlyDealerSales'])->name('yearly-dealer-sales');
    Route::get('/yearly-sales', [ReportController::class, 'yearlySales'])->name('yearly-sales');
    Route::get('/representative-earnings', [ReportController::class, 'representativeEarnings'])->name('representative-earnings');
    Route::get('/stock-detail', [ReportController::class, 'stockDetailReport'])->name('stock-detail');
    Route::get('/stock-summary', [ReportController::class, 'stockSummaryReport'])->name('stock-summary');
    
    // Excel export routes
    Route::get('/logs/export', [ReportController::class, 'exportLogs'])->name('logs.export');
    Route::get('/dealers/export', [ReportController::class, 'exportDealers'])->name('dealers.export');
    Route::get('/sales/export', [ReportController::class, 'exportSales'])->name('sales.export');
    Route::get('/stocks/export', [ReportController::class, 'exportStocks'])->name('stocks.export');
});

// Kullanıcı Yönetimi Routes
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::get('/account', [UserController::class, 'account'])->name('account');
    Route::post('/account', [UserController::class, 'updateAccount'])->name('account.update');
    Route::get('/export', [UserController::class, 'export'])->name('export');
});

// Kod Yönetimi Routes
Route::prefix('codes')->name('codes.')->group(function () {
    Route::get('/', [CodeController::class, 'index'])->name('index');
    Route::get('/create', [CodeController::class, 'create'])->name('create');
    Route::post('/', [CodeController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CodeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CodeController::class, 'update'])->name('update');
    Route::delete('/{id}', [CodeController::class, 'destroy'])->name('destroy');
});

// Ödeme Ayarları Routes
Route::prefix('payments')->name('payments.')->group(function () {
    // Havale hesapları routes
    Route::get('/bank-accounts', [PaymentController::class, 'bankAccounts'])->name('bank-accounts');
    Route::get('/bank-accounts/create', [PaymentController::class, 'createBankAccount'])->name('bank-accounts.create');
    Route::post('/bank-accounts', [PaymentController::class, 'storeBankAccount'])->name('bank-accounts.store');
    
    // Sanal pos routes
    Route::get('/virtual-pos', [PaymentController::class, 'virtualPos'])->name('virtual-pos');
    Route::get('/virtual-pos/create', [PaymentController::class, 'createVirtualPos'])->name('virtual-pos.create');
    Route::post('/virtual-pos', [PaymentController::class, 'storeVirtualPos'])->name('virtual-pos.store');
    Route::get('/virtual-pos/payments', [PaymentController::class, 'virtualPosPayments'])->name('virtual-pos.payments');
});

// Ayarlar Routes
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/general', [SettingController::class, 'general'])->name('general');
    Route::post('/general', [SettingController::class, 'updateGeneral'])->name('general.update');
    Route::get('/desi-prices', [SettingController::class, 'desiPrices'])->name('desi-prices');
    Route::post('/desi-prices', [SettingController::class, 'updateDesiPrices'])->name('desi-prices.update');
    Route::get('/parameters', [SettingController::class, 'parameters'])->name('parameters');
    Route::post('/parameters', [SettingController::class, 'updateParameters'])->name('parameters.update');
    Route::get('/surveys', [SettingController::class, 'surveys'])->name('surveys');
    Route::post('/surveys', [SettingController::class, 'updateSurveys'])->name('surveys.update');
    Route::post('/surveys/options/add', [SettingController::class, 'addSurveyOption'])->name('surveys.options.add');
    Route::post('/surveys/options/update/{id}', [SettingController::class, 'updateSurveyOption'])->name('surveys.options.update');
    Route::get('/surveys/options/delete/{id}', [SettingController::class, 'deleteSurveyOption'])->name('surveys.options.delete');
    Route::post('/surveys/options/reorder', [SettingController::class, 'reorderSurveyOptions'])->name('surveys.options.reorder');
});