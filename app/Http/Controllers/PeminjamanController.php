<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\DetailPinjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Tambahkan ini jika belum ada
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'user', 'denda', 'detailPinjam.buku'])
                                ->orderBy('id_pinjam', 'asc')
                                ->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::all();
        $denda = Denda::all();
        return view('peminjaman.create', compact('anggota', 'buku', 'denda'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'tgl_peminjaman' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1',
            'books' => 'required|array|min:1',
            'books.*' => 'required|exists:buku,id_buku',
            'id_denda' => 'nullable|exists:denda,id_denda',
        ]);

        DB::beginTransaction();
        try {
            $nominalDenda = 0;
            if ($request->id_denda) {
                $jenisDenda = Denda::find($request->id_denda);
                // Logika denda bisa lebih kompleks, ini hanya contoh
                $nominalDenda = $jenisDenda->nominal * $request->lama_pinjam; // Contoh: denda per hari
            }

            $peminjaman = Peminjaman::create([
                'id_anggota' => $request->id_anggota,
                'tgl_peminjaman' => $request->tgl_peminjaman,
                'lama_pinjam' => $request->lama_pinjam,
                'nominal_denda' => $nominalDenda, // Akan diupdate saat pengembalian jika ada keterlambatan
                'id_denda' => $request->id_denda,
                'id_user' => Auth::user()->id_user, // Petugas yang login
            ]);

            foreach ($request->books as $buku_id) {
                DetailPinjam::create([
                    'id_pinjam' => $peminjaman->id_pinjam,
                    'id_buku' => $buku_id,
                    // tgl_kembali null saat peminjaman
                ]);
                // Kurangi stok buku jika ada fitur stok buku
            }

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Peminjaman gagal: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Peminjaman gagal: ' . $e->getMessage());
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'user', 'denda', 'detailPinjam.buku']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $anggota = Anggota::all();
        $buku = Buku::all();
        $denda = Denda::all();
        return view('peminjaman.edit', compact('peminjaman', 'anggota', 'buku', 'denda'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tgl_peminjaman' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1',
            'nominal_denda' => 'nullable|numeric|min:0',
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_denda' => 'nullable|exists:denda,id_denda',
            // Buku yang dipinjam tidak diubah di sini, tapi di detail_pinjam
        ]);

        $peminjaman->update($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::beginTransaction();
        try {
            $peminjaman->detailPinjam()->delete(); // Hapus detail dulu
            $peminjaman->delete();
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus peminjaman: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus peminjaman: ' . $e->getMessage());
        }
    }

    // Metode untuk Pengembalian Buku
    // Menerima id_pinjam dari URL dan id_buku dari request body
    public function kembalikanBuku(Request $request, $id_pinjam) // <-- UBAH TANDA TANGAN METODE INI
    {
        // Validasi input
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku', // Pastikan id_buku dikirim dari form
            'tgl_kembali' => 'required|date',
        ]);

        // Cari record DetailPinjam menggunakan composite primary key
        $detailPinjam = DetailPinjam::where('id_pinjam', $id_pinjam)
                                    ->where('id_buku', $request->id_buku)
                                    ->first();

        if (!$detailPinjam) {
            return back()->with('error', 'Detail peminjaman buku tidak ditemukan.');
        }

        // Pastikan buku belum dikembalikan
        if (!is_null($detailPinjam->tgl_kembali)) {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Hitung keterlambatan dan denda
        $tglPinjam = Carbon::parse($detailPinjam->peminjaman->tgl_peminjaman);
        $tglHarusKembali = $tglPinjam->addDays($detailPinjam->peminjaman->lama_pinjam);
        $tglKembaliAktual = Carbon::parse($request->tgl_kembali);

        $keterlambatanHari = 0;
        // Pastikan relasi denda dimuat atau denda default 0
        $dendaPerHari = $detailPinjam->peminjaman->denda->nominal ?? 0;

        if ($tglKembaliAktual->greaterThan($tglHarusKembali)) {
            $keterlambatanHari = $tglKembaliAktual->diffInDays($tglHarusKembali);
            $totalDendaBukuIni = $keterlambatanHari * $dendaPerHari;

            // Update nominal_denda di tabel peminjaman
            // Pastikan nominal_denda di peminjaman tidak null sebelum ditambah
            $peminjaman = $detailPinjam->peminjaman;
            $peminjaman->nominal_denda = ($peminjaman->nominal_denda ?? 0) + $totalDendaBukuIni;
            $peminjaman->save();
        }

        // Update tanggal kembali di detail_pinjam
        $detailPinjam->update(['tgl_kembali' => $request->tgl_kembali]);

        // Tambah stok buku jika ada fitur stok buku (misal: $detailPinjam->buku->increment('stok'))

        return back()->with('success', 'Buku berhasil dikembalikan! Keterlambatan: ' . $keterlambatanHari . ' hari. Denda buku ini: Rp ' . number_format($totalDendaBukuIni ?? 0, 2, ',', '.') . '.');
    }

    /**
     * Menampilkan detail peminjaman untuk dicetak sebagai kuitansi/struk.
     */
    public function cetakSinglePeminjaman(Peminjaman $peminjaman) // Laravel akan me-resolve Peminjaman berdasarkan id_pinjam
    {
        $peminjaman->load(['anggota', 'user', 'denda', 'detailPinjam.buku']);
        return view('peminjaman.kuitansi_cetak', compact('peminjaman')); // <-- Kita akan buat view baru ini
    }
}