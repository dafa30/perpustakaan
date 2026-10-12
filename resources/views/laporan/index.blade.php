@extends('layouts.admin')

@section('page_title', 'Laporan Perpustakaan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Area Laporan</h4>
    </div>
    <div class="card-body">
        <p>Pilih jenis laporan yang ingin Anda cetak:</p>
        <div class="list-group">
            <a href="{{ route('laporan.peminjaman.cetak') }}" class="list-group-item list-group-item-action">
                Cetak Laporan Peminjaman (Semua)
            </a>
            {{-- Anda bisa tambahkan link laporan lain di sini --}}
            {{-- <a href="#" class="list-group-item list-group-item-action">Cetak Laporan Anggota</a> --}}
            {{-- <a href="#" class="list-group-item list-group-item-action">Cetak Laporan Buku</a> --}}
        </div>
    </div>
</div>
@endsection