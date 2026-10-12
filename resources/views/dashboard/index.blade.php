@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Anggota</div>
                        <div class="text-lg fw-bold">{{ $totalAnggota }}</div>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="{{ route('anggota.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Buku</div>
                        <div class="text-lg fw-bold">{{ $totalBuku }}</div>
                    </div>
                    <i class="bi bi-book fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="{{ route('buku.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-warning h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Peminjaman</div>
                        <div class="text-lg fw-bold">{{ $totalPeminjaman }}</div>
                    </div>
                    <i class="bi bi-journal-check fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="{{ route('peminjaman.index') }}">Lihat Detail</a>
                <div class="small text-warning"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>

    {{-- Kartu Tambahan --}}
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Kategori Buku</div>
                        <div class="text-lg fw-bold">{{ $totalKategoriBuku }}</div>
                    </div>
                    <i class="bi bi-tags fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="{{ route('kategori-buku.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-danger h-100 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        {{-- UBAH TEKS INI --}}
                        <div class="text-white-75 small">Anggota Berdenda</div>
                        {{-- UBAH VARIABEL DAN FORMAT INI --}}
                        <div class="text-lg fw-bold">{{ $jumlahAnggotaDenda }}</div>
                    </div>
                    <i class="bi bi-person-x fs-1"></i> {{-- Menggunakan ikon yang lebih sesuai untuk orang berdenda --}}
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link text-decoration-none" href="{{ route('peminjaman.index') }}">Lihat Detail</a> {{-- Arahkan ke daftar peminjaman untuk melihat denda --}}
                <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
</div>
@endsection