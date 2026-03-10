<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->tenant_id && $user->tenant && ! $user->tenant->is_active) {
            abort(403, 'Your account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
