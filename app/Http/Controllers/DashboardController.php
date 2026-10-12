<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\KategoriBuku;
use App\Models\Denda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil jumlah data untuk ditampilkan di card
        $totalAnggota = Anggota::count();
        $totalBuku = Buku::count();
        $totalPeminjaman = Peminjaman::count();
        $totalKategoriBuku = KategoriBuku::count();

        // --- PERUBAHAN DI SINI ---
        // Menghitung jumlah anggota unik yang memiliki nominal_denda > 0
        $jumlahAnggotaDenda = Peminjaman::where('nominal_denda', '>', 0)
                                        ->distinct('id_anggota')
                                        ->count('id_anggota');
        // --- AKHIR PERUBAHAN ---

        return view('dashboard.index', compact('totalAnggota', 'totalBuku', 'totalPeminjaman', 'totalKategoriBuku', 'jumlahAnggotaDenda')); // Ubah nama variabel
    }
}