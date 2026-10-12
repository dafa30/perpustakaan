@extends('layouts.admin')

@section('page_title', 'Detail Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Peminjaman #{{ $peminjaman->id_pinjam }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3"><strong>ID Peminjaman:</strong> {{ $peminjaman->id_pinjam }}</div>
                <div class="mb-3"><strong>Anggota:</strong> {{ $peminjaman->anggota->nama ?? 'N/A' }}</div>
                <div class="mb-3"><strong>Petugas:</strong> {{ $peminjaman->user->nama_user ?? 'N/A' }}</div>
                <div class="mb-3"><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tgl_peminjaman->format('d M Y') }}</div>
                <div class="mb-3"><strong>Lama Peminjaman:</strong> {{ $peminjaman->lama_pinjam }} hari</div>
                <div class="mb-3"><strong>Jenis Denda:</strong> Rp {{ number_format($peminjaman->denda->nominal ?? 0, 2, ',', '.') }} per hari</div>
                <div class="mb-3"><strong>Total Denda:</strong> Rp {{ number_format($peminjaman->nominal_denda, 2, ',', '.') }}</div>
            </div>
            <div class="col-md-6">
                <h5>Buku-buku yang Dipinjam:</h5>
                <ul class="list-group">
                    @forelse ($peminjaman->detailPinjam as $detail)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $detail->buku->judul ?? 'Buku Tidak Ditemukan' }}</strong>
                                <br>
                                <small>ISBN: {{ $detail->buku->isbn ?? 'N/A' }}</small>
                                <br>
                                <small>Dikembalikan: {{ $detail->tgl_kembali ? $detail->tgl_kembali->format('d M Y') : 'BELUM' }}</small>
                            </div>
                            @if(is_null($detail->tgl_kembali))
                                <form action="{{ route('peminjaman.kembalikan', ['id_pinjam' => $detail->id_pinjam]) }}" method="POST" style="display:inline;" class="ms-auto confirm-submit">
                                    @csrf
                                    <input type="hidden" name="id_buku" value="{{ $detail->id_buku }}">
                                    <input type="date" name="tgl_kembali" class="form-control form-control-sm me-2" value="{{ date('Y-m-d') }}" required style="width:120px; display:inline-block;">
                                    <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                </form>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item">Tidak ada buku dalam peminjaman ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <hr>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali ke Daftar Peminjaman</a>
        {{-- <a href="{{ route('peminjaman.edit', $peminjaman->id_pinjam) }}" class="btn btn-warning">Edit Peminjaman</a> --}}

        <a href="{{ route('peminjaman.cetak_kuitansi', $peminjaman->id_pinjam) }}" target="_blank" class="btn btn-info">Cetak Kuitansi</a>

        <form action="{{ route('peminjaman.destroy', $peminjaman->id_pinjam) }}" method="POST" style="display:inline;" class="confirm-submit">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus Peminjaman</button>
        </form>
    </div>
</div>
@endsection