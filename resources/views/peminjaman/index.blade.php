@extends('layouts.admin')

@section('page_title', 'Daftar Peminjaman')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Daftar Peminjaman Buku</h4>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Input Peminjaman Baru</a>
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
            <input type="text" id="searchInput" class="form-control" placeholder="Cari peminjaman...">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Pinjam</th>
                        <th>Anggota</th>
                        <th>Petugas</th>
                        <th>Tanggal Pinjam</th>
                        <th>Lama Pinjam</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                    <tr>
                        <td>{{ $item->id_pinjam }}</td>
                        <td>{{ $item->anggota->nama ?? 'N/A' }}</td>
                        <td>{{ $item->user->nama_user ?? 'N/A' }}</td>
                        <td>{{ $item->tgl_peminjaman->format('d M Y') }}</td>
                        <td>{{ $item->lama_pinjam }} hari</td>
                        <td>Rp {{ number_format($item->nominal_denda, 2, ',', '.') }}</td>
                        <td>
                            @php
                                $status = 'Dipinjam';
                                foreach($item->detailPinjam as $detail) {
                                    if(is_null($detail->tgl_kembali)) {
                                        $status = 'Dipinjam';
                                        break;
                                    }
                                    $status = 'Sudah Dikembalikan';
                                }
                            @endphp
                            {{ $status }}
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.show', $item->id_pinjam) }}" class="btn btn-info btn-sm">Detail</a>
                            {{-- <a href="{{ route('peminjaman.edit', $item->id_pinjam) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                            <form action="{{ route('peminjaman.destroy', $item->id_pinjam) }}" method="POST" style="display:inline;" class="confirm-submit">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection