<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DealerController;

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
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');

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