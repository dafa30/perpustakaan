<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kategoriBuku = KategoriBuku::all();
        return view('buku.create', compact('kategoriBuku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:'.date('Y'),
            'isbn' => 'required|string|unique:buku,isbn',
            'tgl_input' => 'required|date',
            'jml_halaman' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:kategori_buku,id_kategori',
        ]);

        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoriBuku = KategoriBuku::all();
        return view('buku.edit', compact('buku', 'kategoriBuku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:'.date('Y'),
            'isbn' => ['required', 'string', \Illuminate\Validation\Rule::unique('buku')->ignore($buku->id_buku, 'id_buku')],
            'tgl_input' => 'required|date',
            'jml_halaman' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:kategori_buku,id_kategori',
        ]);

        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->detailPinjam()->count() > 0) {
            return redirect()->route('buku.index')->with('error', 'Tidak dapat menghapus buku karena masih ada di riwayat peminjaman!');
        }
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}