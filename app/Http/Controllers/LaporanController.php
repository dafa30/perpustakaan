<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku; // Pastikan ini diimpor
use App\Models\KategoriBuku;
use App\Models\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index'); // View untuk menampilkan halaman laporan utama
    }

    /**
     * Menampilkan laporan peminjaman dalam format cetak (mirip kuitansi).
     */
    public function cetakPeminjaman(Request $request)
    {
        $peminjaman = Peminjaman::with(['anggota', 'user', 'detailPinjam.buku', 'denda'])
                                ->latest()
                                ->get();
        return view('laporan.peminjaman_cetak', compact('peminjaman'));
    }

    /**
     * Menampilkan laporan daftar buku dalam format cetak.
     */
    public function cetakBuku(Request $request)
    {
        // Ambil semua data buku beserta kategorinya
        $buku = Buku::with('kategori')->orderBy('judul', 'asc')->get();

        return view('laporan.buku_cetak', compact('buku')); // <-- Kita akan buat view baru ini
    }
}