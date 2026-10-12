<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController; // Pastikan ini diimpor
use App\Http\Controllers\UserController; // Untuk manajemen user sistem
use App\Http\Controllers\DashboardController; // Untuk halaman dashboard admin
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute autentikasi dasar (login, register, logout)
// Kita mendefinisikannya secara manual karena kita menghapus controller yang tidak diperlukan Auth::routes() umum.
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// Rute default '/' akan selalu mengarahkan ke halaman login.
// Ini adalah titik masuk utama aplikasi Anda.
Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');


// Grup rute yang memerlukan autentikasi
// Semua rute di dalam grup ini hanya bisa diakses oleh user yang sudah login.
Route::middleware(['auth'])->group(function () {

    // Rute Dashboard utama setelah login
    // Admin akan diarahkan ke sini oleh LoginController@redirectTo
    // Anggota Sistem akan diarahkan ke /buku oleh LoginController@redirectTo
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // --- Rute untuk Admin dan Anggota Sistem (Akses Umum Setelah Login) ---
    // Middleware 'is_anggota' akan memastikan user adalah 'anggota' atau 'admin' (karena admin juga termasuk anggota sistem)
    Route::middleware(['is_anggota'])->group(function() {
        // Data Master
        Route::resource('anggota', AnggotaController::class);
        Route::resource('buku', BukuController::class);
        // Menggunakan parameter 'kategori_buku' untuk menghindari konflik dengan 'kategori-buku' di URL
        Route::resource('kategori-buku', KategoriBukuController::class)->parameters(['kategori-buku' => 'kategori_buku']);
        Route::resource('denda', DendaController::class);

        // Transaksi
        Route::resource('peminjaman', PeminjamanController::class);
        // Rute POST untuk mengembalikan buku, menerima id_pinjam dari URL dan id_buku dari form
        Route::post('peminjaman/detail-pinjam/{id_pinjam}/kembalikan', [PeminjamanController::class, 'kembalikanBuku'])->name('peminjaman.kembalikan');
        // Rute GET untuk mencetak kuitansi peminjaman tunggal
        Route::get('peminjaman/{id_pinjam}/cetak-kuitansi', [PeminjamanController::class, 'cetakSinglePeminjaman'])->name('peminjaman.cetak_kuitansi'); // <-- TAMBAHAN RUTE INI

        // Detail Pinjam - hanya melihat (index dan show)
        Route::resource('detail-pinjam', App\Http\Controllers\DetailPinjamController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        // Rute cetak laporan peminjaman (semua)
        Route::get('laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });


    // --- Rute KHUSUS Admin (Manajemen User Sistem) ---
    // Hanya user dengan role 'admin' yang bisa mengakses modul ini.
    Route::middleware(['is_admin'])->group(function() {
        Route::resource('users', UserController::class); // User di sini adalah user sistem untuk login
    });
});
