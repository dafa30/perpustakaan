@extends('layouts.admin')

@section('page_title', 'Detail Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Buku: {{ $buku->judul }}</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID Buku:</strong> {{ $buku->id_buku }}
        </div>
        <div class="mb-3">
            <strong>Judul:</strong> {{ $buku->judul }}
        </div>
        <div class="mb-3">
            <strong>Pengarang:</strong> {{ $buku->pengarang }}
        </div>
        <div class="mb-3">
            <strong>Penerbit:</strong> {{ $buku->penerbit }}
        </div>
        <div class="mb-3">
            <strong>Tahun Terbit:</strong> {{ $buku->tahun }}
        </div>
        <div class="mb-3">
            <strong>ISBN:</strong> {{ $buku->isbn }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Input:</strong> {{ $buku->tgl_input->format('d M Y') }}
        </div>
        <div class="mb-3">
            <strong>Jumlah Halaman:</strong> {{ $buku->jml_halaman }}
        </div>
        <div class="mb-3">
            <strong>Kategori:</strong> {{ $buku->kategori->kategori ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Dibuat Pada:</strong> {{ $buku->created_at->format('d M Y, H:i') }}
        </div>
        <div class="mb-3">
            <strong>Diperbarui Pada:</strong> {{ $buku->updated_at->format('d M Y, H:i') }}
        </div>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection