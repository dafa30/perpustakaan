@extends('layouts.admin')

@section('page_title', 'Tambah Kategori Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Tambah Kategori Buku</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kategori-buku.store') }}" method="POST" class="confirm-submit">
            @csrf
            <div class="mb-3">
                <label for="kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori') }}" required>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('kategori-buku.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection 