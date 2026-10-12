<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\User;
use App\Models\DetailPinjam;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Pastikan ada data di tabel lain
        $anggota1 = Anggota::first();
        $anggota2 = Anggota::skip(1)->first();
        $anggota3 = Anggota::skip(2)->first();
        $anggota4 = Anggota::skip(3)->first();
        $anggota5 = Anggota::skip(4)->first();

        $buku1 = Buku::first();
        $buku2 = Buku::skip(1)->first();
        $buku3 = Buku::skip(2)->first();
        $buku4 = Buku::skip(3)->first();
        $buku5 = Buku::skip(4)->first();

        $userAdmin = User::where('role', 'admin')->first();
        $userAnggotaSistem = User::where('role', 'anggota')->first(); // <-- AMBIL USER ANGGOTA SISTEM

        $denda1000 = Denda::where('nominal', 1000)->first();
        $denda500 = Denda::where('nominal', 500)->first();
        $denda2000 = Denda::where('nominal', 2000)->first(); // Pastikan ini juga ada jika digunakan

        // Peminjaman 1: Anggota 1, Buku 1, Oleh Admin, Belum Kembali, Tanpa Denda
        $p1 = Peminjaman::create([
            'id_anggota' => $anggota1->id_anggota,
            'tgl_peminjaman' => Carbon::now()->subDays(10),
            'lama_pinjam' => 7,
            'nominal_denda' => 0,
            'id_denda' => null,
            'id_user' => $userAdmin->id_user,
        ]);
        DetailPinjam::create([
            'id_pinjam' => $p1->id_pinjam,
            'id_buku' => $buku1->id_buku,
            'tgl_kembali' => null,
        ]);

        // Peminjaman 2: Anggota 2, Buku 2, Oleh Anggota Sistem, Sudah Kembali, Ada Denda
        $p2 = Peminjaman::create([
            'id_anggota' => $anggota2->id_anggota,
            'tgl_peminjaman' => Carbon::now()->subDays(15),
            'lama_pinjam' => 7,
            'nominal_denda' => 8 * ($denda1000->nominal ?? 0), // 8 hari terlambat
            'id_denda' => $denda1000->id_denda,
            'id_user' => $userAnggotaSistem->id_user, // <-- GUNAKAN USER ANGGOTA SISTEM
        ]);
        DetailPinjam::create([
            'id_pinjam' => $p2->id_pinjam,
            'id_buku' => $buku2->id_buku,
            'tgl_kembali' => Carbon::now()->subDays(7), // Dikembalikan 8 hari setelah jatuh tempo
        ]);

        // Peminjaman 3: Anggota 3, Buku 3 & Buku 4, Oleh Admin, Belum Kembali, Ada Denda (terlambat)
        $p3 = Peminjaman::create([
            'id_anggota' => $anggota3->id_anggota,
            'tgl_peminjaman' => Carbon::now()->subDays(10),
            'lama_pinjam' => 3,
            'nominal_denda' => 0, // Denda akan dihitung saat pengembalian
            'id_denda' => $denda500->id_denda,
            'id_user' => $userAdmin->id_user,
        ]);
        DetailPinjam::create([
            'id_pinjam' => $p3->id_pinjam,
            'id_buku' => $buku3->id_buku,
            'tgl_kembali' => null,
        ]);
        DetailPinjam::create([
            'id_pinjam' => $p3->id_pinjam,
            'id_buku' => $buku4->id_buku,
            'tgl_kembali' => null,
        ]);

        // Peminjaman 4: Anggota 4, Buku 5, Oleh Anggota Sistem, Sudah Kembali Tepat Waktu
        $p4 = Peminjaman::create([
            'id_anggota' => $anggota4->id_anggota,
            'tgl_peminjaman' => Carbon::now()->subDays(7),
            'lama_pinjam' => 7,
            'nominal_denda' => 0,
            'id_denda' => null,
            'id_user' => $userAnggotaSistem->id_user, // <-- GUNAKAN USER ANGGOTA SISTEM
        ]);
        DetailPinjam::create([
            'id_pinjam' => $p4->id_pinjam,
            'id_buku' => $buku5->id_buku,
            'tgl_kembali' => Carbon::now(),
        ]);

        // Peminjaman 5: Anggota 5, Buku 1 (lagi), Oleh Admin, Belum Kembali, Ada Denda (terlambat)
        $p5 = Peminjaman::create([
            'id_anggota' => $anggota5->id_anggota,
            'tgl_peminjaman' => Carbon::now()->subDays(20),
            'lama_pinjam' => 7,
            'nominal_denda' => 0, // Denda akan dihitung saat pengembalian
            'id_denda' => $denda2000->id_denda ?? null,
            'id_user' => $userAdmin->id_user,
        ]);
        DetailPinjam::create([
            'id_pinjam' => $p5->id_pinjam,
            'id_buku' => $buku1->id_buku,
            'tgl_kembali' => null,
        ]);
    }
}