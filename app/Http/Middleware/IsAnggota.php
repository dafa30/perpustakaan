<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAnggota
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login dan perannya adalah 'anggota' atau 'admin'
        if (Auth::check() && (Auth::user()->isAnggota() || Auth::user()->isAdmin())) {
            return $next($request);
        }

        // Jika tidak, redirect ke dashboard atau tampilkan error 403
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai Anggota Sistem.');
        // Atau: abort(403, 'Akses Dilarang. Hanya Anggota Sistem.');
    }
}