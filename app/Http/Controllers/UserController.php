<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'petugas'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255|unique:users,nama_user',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'role' => ['required', 'string', Rule::in(['admin', 'petugas'])],
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'petugas'];
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_user' => ['required', 'string', 'max:255', Rule::unique('users', 'nama_user')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'role' => ['required', 'string', Rule::in(['admin', 'petugas'])],
        ]);

        $user->nama_user = $request->nama_user;
        $user->full_name = $request->full_name;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->peminjaman()->count() > 0) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus user karena terkait dengan riwayat peminjaman!');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}