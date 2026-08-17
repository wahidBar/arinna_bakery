<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Proteksi route admin. Didaftarkan sebagai alias 'role:admin' di bootstrap/app.php:
     *
     * $middleware->alias([
     *     'role' => \App\Http\Middleware\EnsureUserIsAdmin::class,
     * ]);
     *
     * lalu dipakai di route: Route::middleware(['auth', 'role:admin'])
     */
    public function handle(Request $request, Closure $next, string $role = 'admin'): Response
    {
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
