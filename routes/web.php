<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\Central\AuthenticatedSessionController as CentralAuthenticatedSessionController;
use App\Http\Controllers\Central\DashboardController as CentralDashboardController;
use App\Http\Controllers\Central\PaymentController as CentralPaymentController;
use App\Http\Controllers\Central\PlanController as CentralPlanController;
use App\Http\Controllers\Central\TenantController as CentralTenantController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains', ['localhost']) as $domain) {
    Route::domain($domain)->group(function (): void {
        Route::view('/', 'welcome')->name('welcome');

        Route::middleware('guest')->group(function (): void {
            Route::get('/login', [CentralAuthenticatedSessionController::class, 'create'])->name('central.login');
            Route::post('/login', [CentralAuthenticatedSessionController::class, 'store'])->name('central.login.store');
            Route::get('/register', static fn (): RedirectResponse => redirect('/login')->with('error', 'Registration is closed.'))->name('central.register');
        });

        Route::post('/logout', [CentralAuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('central.logout');

        Route::prefix('central')
            ->name('central.')
            ->middleware(['auth', 'role:super_admin'])
            ->group(function (): void {
                Route::get('/dashboard', [CentralDashboardController::class, 'index'])->name('dashboard');

                Route::post('/tenants/{tenant}/suspend', [CentralTenantController::class, 'suspend'])->name('tenants.suspend');
                Route::post('/tenants/{tenant}/activate', [CentralTenantController::class, 'activate'])->name('tenants.activate');
                Route::post('/tenants/{tenant}/resend-credentials', [CentralTenantController::class, 'resendCredentials'])->name('tenants.resend-credentials');
                Route::resource('tenants', CentralTenantController::class);

                Route::resource('plans', CentralPlanController::class)->except('show');

                Route::get('/payments', [CentralPaymentController::class, 'index'])->name('payments.index');
                Route::post('/payments/{tenant}/mark-paid', [CentralPaymentController::class, 'markPaid'])->name('payments.mark-paid');
            });
    });
}
