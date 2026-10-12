@extends('layouts.admin')

@section('page_title', 'Daftar Denda')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Daftar Nominal Denda</h4>
        <a href="{{ route('denda.create') }}" class="btn btn-primary">Tambah Denda</a>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Cari denda...">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Denda</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($denda as $item)
                    <tr>
                        <td>{{ $item->id_denda }}</td>
                        <td>Rp {{ number_format($item->nominal, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('denda.show', $item->id_denda) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('denda.edit', $item->id_denda) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('denda.destroy', $item->id_denda) }}" method="POST" style="display:inline;" class="confirm-submit">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data denda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection