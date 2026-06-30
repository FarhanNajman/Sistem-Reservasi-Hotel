<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        // 2. Cek apakah role user saat ini diizinkan
        $userRole = auth()->user()->role;
        if (!in_array($userRole, $roles)) {
            if ($userRole === 'user') {
                return redirect('/reservasi_hotel')->with('error', 'Anda tidak memiliki wewenang untuk mengakses halaman admin.');
            }
            abort(403, 'Aksi tidak diizinkan.');
        }

        return $next($request);
    }
}
