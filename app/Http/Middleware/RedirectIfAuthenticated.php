<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                // --- PERBAIKAN DI SINI ---
                // Jika user sudah login dan mencoba akses rute guest (/login, /register),
                // arahkan mereka ke dashboard yang sesuai peran mereka.
                // JANGAN PERNAH mengarahkan ke '/login' di sini.
                if ($user->isAdmin()) {
                    Log::info('RedirectIfAuthenticated: User ' . $user->nama_user . ' (Admin) already authenticated, redirecting to /anggota.');
                    return redirect('/anggota');
                } elseif ($user->isAnggota()) {
                    Log::info('RedirectIfAuthenticated: User ' . $user->nama_user . ' (Anggota) already authenticated, redirecting to /buku.');
                    return redirect('/buku');
                }
                // Fallback jika peran tidak dikenal, arahkan ke halaman default yang valid.
                Log::warning('RedirectIfAuthenticated: User ' . $user->nama_user . ' has unrecognized role, redirecting to /anggota (default fallback).');
                return redirect('/anggota'); // <-- UBAH INI: Redirect ke halaman default yang valid
                // --- AKHIR PERBAIKAN ---
            }
        }
        return $next($request);
    }
}