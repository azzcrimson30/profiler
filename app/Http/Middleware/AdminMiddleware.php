<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin Middleware
 *
 * Restricts access to admin-only routes.
 * Checks that the authenticated user has is_admin = true.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->hasRole('administrator')) {
            abort(403, 'Unauthorized. Administrator access required.');
        }

        return $next($request);
    }
}