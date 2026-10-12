@extends('layouts.admin')

@section('page_title', 'Semua Detail Peminjaman Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Daftar Detail Peminjaman Buku</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari detail peminjaman...">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>Judul Buku</th>
                        <th>ISBN</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detailPinjam as $item)
                    <tr>
                        <td>{{ $item->id_pinjam }}</td>
                        <td>{{ $item->buku->judul ?? 'N/A' }}</td>
                        <td>{{ $item->buku->isbn ?? 'N/A' }}</td>
                        <td>{{ $item->peminjaman->tgl_peminjaman->format('d M Y') ?? 'N/A' }}</td>
                        <td>{{ $item->tgl_kembali ? $item->tgl_kembali->format('d M Y') : 'BELUM' }}</td>
                        <td>
                            @if(is_null($item->tgl_kembali))
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.show', $item->id_pinjam) }}" class="btn btn-info btn-sm">Lihat Peminjaman</a>
                            @if(is_null($item->tgl_kembali))
                                <form action="{{ route('peminjaman.kembalikan', $item->id_pinjam) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="id_buku" value="{{ $item->id_buku }}">
                                    <input type="date" name="tgl_kembali" class="form-control form-control-sm me-2" value="{{ date('Y-m-d') }}" required style="width:120px; display:inline-block;">
                                    <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data detail peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection