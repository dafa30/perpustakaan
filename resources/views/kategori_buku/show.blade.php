@extends('layouts.admin')

@section('page_title', 'Detail Kategori Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Kategori Buku: {{ $kategoriBuku->kategori }}</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID Kategori:</strong> {{ $kategoriBuku->id_kategori }}
        </div>
        <div class="mb-3">
            <strong>Nama Kategori:</strong> {{ $kategoriBuku->kategori }}
        </div>
        <div class="mb-3">
            <strong>Dibuat Pada:</strong> {{ $kategoriBuku->created_at->format('d M Y, H:i') }}
        </div>
        <div class="mb-3">
            <strong>Diperbarui Pada:</strong> {{ $kategoriBuku->updated_at->format('d M Y, H:i') }}
        </div>
        <a href="{{ route('kategori-buku.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('kategori-buku.edit', $kategoriBuku->id_kategori) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection