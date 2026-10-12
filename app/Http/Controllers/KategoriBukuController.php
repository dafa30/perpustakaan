<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $kategoriBuku = KategoriBuku::all();
        return view('kategori_buku.index', compact('kategoriBuku'));
    }

    public function create()
    {
        return view('kategori_buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255|unique:kategori_buku,kategori',
        ]);

        KategoriBuku::create($request->all());
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori buku berhasil ditambahkan!');
    }

    public function show(KategoriBuku $kategoriBuku)
    {
        return view('kategori_buku.show', compact('kategoriBuku'));
    }

    public function edit(KategoriBuku $kategoriBuku)
    {
        return view('kategori_buku.edit', compact('kategoriBuku'));
    }

    public function update(Request $request, KategoriBuku $kategoriBuku)
    {
        $request->validate([
            'kategori' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('kategori_buku')->ignore($kategoriBuku->id_kategori, 'id_kategori')],
        ]);

        $kategoriBuku->update($request->all());
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori buku berhasil diperbarui!');
    }

    public function destroy(KategoriBuku $kategoriBuku)
    {
        if ($kategoriBuku->buku()->count() > 0) {
            return redirect()->route('kategori-buku.index')->with('error', 'Tidak dapat menghapus kategori karena memiliki buku terkait!');
        }
        $kategoriBuku->delete();
        return redirect()->route('kategori-buku.index')->with('success', 'Kategori buku berhasil dihapus!');
    }
}