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

// Mesaj Yönetimi
Route::prefix('messages')->group(function () {
    Route::get('/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::post('/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/{message}', [MessageController::class, 'show'])->name('messages.show');
});

// Tanımlar Modülü Routes
Route::prefix('definitions')->name('definitions.')->group(function () {
    // Sections
    Route::get('/sections', [DefinitionController::class, 'sections'])->name('sections');
    Route::post('/sections/store', [DefinitionController::class, 'storeSection'])->name('sections.store');
    Route::put('/sections/{section}', [DefinitionController::class, 'updateSection'])->name('sections.update');
    Route::delete('/sections/{section}', [DefinitionController::class, 'deleteSection'])->name('sections.delete');

    // Categories
    Route::get('/categories', [DefinitionController::class, 'categories'])->name('categories');
    Route::post('/categories/store', [DefinitionController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [DefinitionController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [DefinitionController::class, 'deleteCategory'])->name('categories.delete');

    // Contents
    Route::get('/contents', [DefinitionController::class, 'contents'])->name('contents');
    Route::get('/contents-list', [DefinitionController::class, 'contentsList'])->name('contents.list');
    Route::post('/contents/store', [DefinitionController::class, 'storeContent'])->name('contents.store');
    Route::put('/contents/{content}', [DefinitionController::class, 'updateContent'])->name('contents.update');
    Route::delete('/contents/{content}', [DefinitionController::class, 'deleteContent'])->name('contents.delete');

    // Slides
    Route::get('/slides', [DefinitionController::class, 'slides'])->name('slides');
    Route::post('/slides/store', [DefinitionController::class, 'storeSlide'])->name('slides.store');
    Route::put('/slides/{slide}', [DefinitionController::class, 'updateSlide'])->name('slides.update');
    Route::delete('/slides/{slide}', [DefinitionController::class, 'deleteSlide'])->name('slides.delete');

    // Discount Codes
    Route::get('/discount-codes', [DefinitionController::class, 'discountCodes'])->name('discount-codes');
    Route::post('/discount-codes/store', [DefinitionController::class, 'storeDiscountCode'])->name('discount-codes.store');
    Route::put('/discount-codes/{discountCode}', [DefinitionController::class, 'updateDiscountCode'])->name('discount-codes.update');
    Route::delete('/discount-codes/{discountCode}', [DefinitionController::class, 'deleteDiscountCode'])->name('discount-codes.delete');

    // Discount Types
    Route::get('/discount-types', [DefinitionController::class, 'discountTypes'])->name('discount-types');
    Route::get('/discount-types-list', [DefinitionController::class, 'discountTypesList'])->name('discount-types.list');
    Route::post('/discount-types/store', [DefinitionController::class, 'storeDiscountType'])->name('discount-types.store');
    Route::put('/discount-types/{discountType}', [DefinitionController::class, 'updateDiscountType'])->name('discount-types.update');
    Route::delete('/discount-types/{discountType}', [DefinitionController::class, 'deleteDiscountType'])->name('discount-types.delete');

    // Transfer
    Route::get('/transfer', [DefinitionController::class, 'transfer'])->name('transfer');
    Route::post('/transfer/start', [DefinitionController::class, 'startTransfer'])->name('transfer.start');

    // File Import
    Route::get('/file-import', [DefinitionController::class, 'fileImport'])->name('file-import');
    Route::post('/file-import/start', [DefinitionController::class, 'startFileImport'])->name('file-import.start');

    // Photo Upload
    Route::get('/photo-upload', [DefinitionController::class, 'photoUpload'])->name('photo-upload');
    Route::post('/photo-upload/upload', [DefinitionController::class, 'uploadPhoto'])->name('photo-upload.upload');
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
});

// Kullanıcı Yönetimi Routes
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/account', [UserController::class, 'account'])->name('account');
    Route::post('/account', [UserController::class, 'updateAccount'])->name('account.update');
});

// Kod Yönetimi Routes
Route::prefix('codes')->name('codes.')->group(function () {
    Route::get('/', [CodeController::class, 'index'])->name('index');
    Route::get('/create', [CodeController::class, 'create'])->name('create');
    Route::post('/', [CodeController::class, 'store'])->name('store');
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
});