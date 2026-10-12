@extends('layouts.admin')

@section('page_title', 'Detail Pinjam Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Peminjaman Buku</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID Peminjaman:</strong> {{ $detailPinjam->id_pinjam }}
        </div>
        <div class="mb-3">
            <strong>Judul Buku:</strong> {{ $detailPinjam->buku->judul ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>ISBN Buku:</strong> {{ $detailPinjam->buku->isbn ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Nama Anggota:</strong> {{ $detailPinjam->peminjaman->anggota->nama ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Peminjaman:</strong> {{ $detailPinjam->peminjaman->tgl_peminjaman->format('d M Y') ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Lama Pinjam:</strong> {{ $detailPinjam->peminjaman->lama_pinjam ?? 'N/A' }} hari
        </div>
        <div class="mb-3">
            <strong>Tanggal Kembali:</strong> {{ $detailPinjam->tgl_kembali ? $detailPinjam->tgl_kembali->format('d M Y') : 'Belum Dikembalikan' }}
        </div>
        <div class="mb-3">
            <strong>Status:</strong>
            @if(is_null($detailPinjam->tgl_kembali))
                <span class="badge bg-warning text-dark">Dipinjam</span>
            @else
                <span class="badge bg-success">Dikembalikan</span>
            @endif
        </div>

        @if(is_null($detailPinjam->tgl_kembali))
            <hr>
            <h5>Form Pengembalian:</h5>
            <form action="{{ route('peminjaman.kembalikan', $detailPinjam->id_pinjam) }}" method="POST" class="confirm-submit">
                @csrf
                <input type="hidden" name="id_buku" value="{{ $detailPinjam->id_buku }}">
                <div class="mb-3">
                    <label for="tgl_kembali" class="form-label">Tanggal Pengembalian Aktual</label>
                    <input type="date" class="form-control @error('tgl_kembali') is-invalid @enderror" id="tgl_kembali" name="tgl_kembali" value="{{ old('tgl_kembali', date('Y-m-d')) }}" required>
                    @error('tgl_kembali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Kembalikan Buku Ini</button>
            </form>
        @endif
        <hr>
        <a href="{{ route('detail-pinjam.index') }}" class="btn btn-secondary">Kembali ke Daftar Detail</a>
    </div>
</div>
@endsection