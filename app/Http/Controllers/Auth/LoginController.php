<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * This method is overridden to provide role-based redirection.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user(); // Dapatkan objek user yang terautentikasi

        if ($user->isAdmin()) {
            // Jika peran adalah 'admin', arahkan ke halaman daftar anggota (dashboard admin)
            Log::info('LoginController: User ' . $user->nama_user . ' (Admin) logged in, redirecting to /anggota.');
            return '/anggota';
        } elseif ($user->isAnggota()) {
            // Jika peran adalah 'anggota', arahkan ke halaman daftar buku
            Log::info('LoginController: User ' . $user->nama_user . ' (Anggota) logged in, redirecting to /buku.');
            return '/buku';
        }

        // --- PERBAIKAN DI SINI ---
        // Fallback jika peran tidak dikenal atau tidak diatur.
        // JANGAN PERNAH mengarahkan ke '/login' di sini jika user sudah terautentikasi.
        // Arahkan ke halaman yang valid yang bisa diakses user terautentikasi (misal: halaman default untuk semua user login).
        Log::warning('LoginController: User ' . $user->nama_user . ' has an unrecognized role (' . $user->role . '), redirecting to /anggota (default fallback).');
        return '/anggota'; // <-- UBAH INI: Redirect ke halaman default yang valid (misal: dashboard admin)
        // --- AKHIR PERBAIKAN ---
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectPath())->with(
            'welcome',
            $user->full_name
        );
    }

    /**
     * Create a new controller instance.
     * Middleware 'guest' memastikan hanya user yang belum login yang bisa mengakses halaman login/register.
     * 'except('logout')' berarti middleware ini tidak berlaku untuk rute logout.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     * Overrides the default 'email' to use 'nama_user' for authentication.
     *
     * @return string
     */
    public function username()
    {
        return 'nama_user'; // Menggunakan kolom 'nama_user' dari tabel 'users' sebagai username
    }

    // Anda bisa menambahkan override metode AuthenticatesUsers lainnya di sini untuk debugging atau custom logic,
    // seperti 'authenticated', 'sendFailedLoginResponse', atau 'logout' jika diperlukan.
    // Contoh:
    /*
    protected function authenticated(Request $request, $user)
    {
        // Logika tambahan setelah user berhasil login
        Log::info('User ' . $user->nama_user . ' successfully authenticated.');
        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        Log::info('User ' . (Auth::check() ? Auth::user()->nama_user : 'N/A') . ' logging out.');
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah berhasil logout.');
    }
    */
}
