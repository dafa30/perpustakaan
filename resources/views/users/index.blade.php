@extends('layouts.admin')

@section('page_title', 'Manajemen User Sistem')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Daftar User Sistem</h4>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User Baru</a>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari user...">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>Nama User</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $item)
                    <tr>
                        <td>{{ $item->id_user }}</td>
                        <td>{{ $item->nama_user }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ ucfirst($item->role) }}</td>
                        <td>
                            <a href="{{ route('users.show', $item->id_user) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('users.edit', $item->id_user) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $item->id_user) }}" method="POST" style="display:inline;" class="confirm-submit">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data user sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection