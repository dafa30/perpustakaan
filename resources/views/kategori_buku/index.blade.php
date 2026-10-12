@extends('layouts.admin')

@section('page_title', 'Daftar Kategori Buku')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Daftar Kategori Buku</h4>
        <a href="{{ route('kategori-buku.create') }}" class="btn btn-primary">Tambah Kategori</a>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Cari kategori...">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Kategori</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoriBuku as $item)
                    <tr>
                        <td>{{ $item->id_kategori }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>
                            <a href="{{ route('kategori-buku.show', $item->id_kategori) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('kategori-buku.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('kategori-buku.destroy', $item->id_kategori) }}" method="POST" style="display:inline;" class="confirm-submit">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data kategori buku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection