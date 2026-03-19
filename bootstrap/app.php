<?php

use App\Http\Middleware\EnsureTenantIsActive;
use App\Http\Middleware\SetTenantContext;
use App\Providers\AuthServiceProvider;
use App\Providers\TenancyServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        AuthServiceProvider::class,
        TenancyServiceProvider::class,
    ], false)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo(function (Illuminate\Http\Request $request) {
            $centralDomains = config('tenancy.central_domains', ['localhost', 'developement.localhost', '127.0.0.1']);
            if (in_array($request->getHost(), $centralDomains)) {
                return route('central.dashboard');
            }
            return route('dashboard', ['tenant' => tenant('id') ?? current(explode('.', $request->getHost()))]);
        });

        $middleware->alias([
            'tenant.context' => SetTenantContext::class,
            'tenant.active' => EnsureTenantIsActive::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
