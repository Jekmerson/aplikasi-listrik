<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     * Only allow users with Admin role to access.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->level->nama_level;

        if ($userRole !== 'Admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
