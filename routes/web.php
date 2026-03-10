<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\CreditPaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Super Admin routes (no tenant context needed)
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'superAdmin'])->name('dashboard');
    Route::resource('tenants', TenantController::class);
    Route::resource('plans', PlanController::class);
});

// Tenant routes (require tenant context + active tenant)
Route::middleware(['auth', 'tenant.context', 'tenant.active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Branches (admin only)
    Route::resource('branches', BranchController::class);

    // Users (admin only)
    Route::resource('users', UserController::class);

    // Customers
    Route::resource('customers', CustomerController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Sales
    Route::resource('sales', SaleController::class)->except(['edit', 'update']);

    // Credits
    Route::resource('credits', CreditController::class)->except(['edit', 'update', 'destroy']);
    Route::post('credits/{credit}/payments', [CreditPaymentController::class, 'store'])->name('credits.payments.store');

    // Reports
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/credits', [ReportController::class, 'credits'])->name('reports.credits');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
});

require __DIR__.'/auth.php';
