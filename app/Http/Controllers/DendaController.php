<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $denda = Denda::all();
        return view('denda.index', compact('denda'));
    }

    public function create()
    {
        return view('denda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:0',
        ]);

        Denda::create($request->all());
        return redirect()->route('denda.index')->with('success', 'Denda berhasil ditambahkan!');
    }

    public function show(Denda $denda)
    {
        return view('denda.show', compact('denda'));
    }

    public function edit(Denda $denda)
    {
        return view('denda.edit', compact('denda'));
    }

    public function update(Request $request, Denda $denda)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:0',
        ]);

        $denda->update($request->all());
        return redirect()->route('denda.index')->with('success', 'Denda berhasil diperbarui!');
    }

    public function destroy(Denda $denda)
    {
        if ($denda->peminjaman()->count() > 0) {
            return redirect()->route('denda.index')->with('error', 'Tidak dapat menghapus denda karena terkait dengan riwayat peminjaman!');
        }
        $denda->delete();
        return redirect()->route('denda.index')->with('success', 'Denda berhasil dihapus!');
    }
}