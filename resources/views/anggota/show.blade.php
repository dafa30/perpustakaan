@extends('layouts.admin')

@section('page_title', 'Detail Anggota')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Anggota: {{ $anggota->nama }}</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID Anggota:</strong> {{ $anggota->id_anggota }}
        </div>
        <div class="mb-3">
            <strong>Nama Lengkap:</strong> {{ $anggota->nama }}
        </div>
        <div class="mb-3">
            <strong>Alamat:</strong> {{ $anggota->alamat ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Nomor HP:</strong> {{ $anggota->no_hp }}
        </div>
        <div class="mb-3">
            <strong>Email:</strong> {{ $anggota->email }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Lahir:</strong> {{ $anggota->tgl_lahir->format('d M Y') }}
        </div>
        <div class="mb-3">
            <strong>Tanggal Daftar:</strong> {{ $anggota->tgl_daftar->format('d M Y') }}
        </div>
        <div class="mb-3">
            <strong>Dibuat Pada:</strong> {{ $anggota->created_at->format('d M Y, H:i') }}
        </div>
        <div class="mb-3">
            <strong>Diperbarui Pada:</strong> {{ $anggota->updated_at->format('d M Y, H:i') }}
        </div>
        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('anggota.edit', $anggota->id_anggota) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection