<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Pastikan ini diimpor jika belum ada

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:20|unique:anggota,no_hp',
            'email' => 'required|email|max:255|unique:anggota,email',
            'tgl_lahir' => 'required|date',
            'tgl_daftar' => 'required|date',
        ]);

        Anggota::create($request->all());
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Anggota $anggota)
    {
        return view('anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     * Mengambil data anggota secara manual, bukan melalui Route Model Binding.
     */
    public function edit($id_anggota) // <-- UBAH TANDA TANGAN METODE INI
    {
        // Cari anggota secara manual berdasarkan ID
        $anggota = Anggota::find($id_anggota);

        // Jika anggota tidak ditemukan, arahkan kembali dengan error
        if (!$anggota) {
            return redirect()->route('anggota.index')->with('error', 'Data Anggota tidak ditemukan!');
        }

        // --- HAPUS DD() INI ---
        // dd($anggota);
        // --- AKHIR DD() ---

        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => ['required', 'string', 'max:20', Rule::unique('anggota')->ignore($anggota->id_anggota, 'id_anggota')],
            'email' => ['required', 'email', 'max:255', Rule::unique('anggota')->ignore($anggota->id_anggota, 'id_anggota')],
            'tgl_lahir' => 'required|date',
            'tgl_daftar' => 'required|date',
        ]);

        $anggota->update($request->all());
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->peminjaman()->count() > 0) {
            return redirect()->route('anggota.index')->with('error', 'Tidak dapat menghapus anggota karena memiliki riwayat peminjaman!');
        }
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
