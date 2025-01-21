<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BulkOrderController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PaymentController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('layouts.main');
    });

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $accountType = Auth::user()->account_type ?? '';

        if ($accountType === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $accountType === 'regular' 
            ? redirect()->route('regular.dashboard') 
            : ($accountType === 'bulk' 
                ? redirect()->route('bulk.dashboard') 
                : redirect()->route('login')->with('error', 'Invalid account type.'));
    })->name('dashboard');

    // Regular User Dashboard
    Route::get('/regular-dashboard', [DashboardController::class, 'regularDashboard'])->name('regular.dashboard');

    // Bulk User Dashboard
    Route::get('/bulk-dashboard', [DashboardController::class, 'bulkDashboard'])->name('bulk.dashboard');
    
    // Bulk Order Management Routes
    Route::get('/bulk-orders', [BulkOrderController::class, 'index'])->name('bulk.orders.index');
    Route::get('/bulk-orders/create', [BulkOrderController::class, 'create'])->name('bulk.orders.create');
    Route::post('/bulk-orders', [BulkOrderController::class, 'store'])->name('bulk.orders.store');
    Route::get('/bulk-orders/{id}/edit', [BulkOrderController::class, 'edit'])->name('bulk.orders.edit');
    Route::put('/bulk-orders/{id}', [BulkOrderController::class, 'update'])->name('bulk.orders.update');
    Route::delete('/bulk-orders/{id}', [BulkOrderController::class, 'destroy'])->name('bulk.orders.destroy');
    
    // Payment Routes
    Route::post('/payment/bulk/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.bulk.initiate'); // Initiate payment
    Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success'); // Payment success
    
    // Route to handle payment initiation
    Route::post('/payment/bulk/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.bulk.initiate');

    // Route to handle payment success
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    // Admin Update Order Status Route
    Route::put('/admin/update-order-status/{id}/{type}', [AdminDashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');

    // Services and About Us Pages
    Route::get('services', [PageController::class, 'services'])->name('services');
    Route::get('about', [PageController::class, 'about'])->name('about');

    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile Edit Routes
    Route::get('/profile/edit', [RegisterController::class, 'showEditProfileForm'])->name('edit.profile');
    Route::post('/profile/edit', [RegisterController::class, 'updateProfile'])->name('update.profile');
});
