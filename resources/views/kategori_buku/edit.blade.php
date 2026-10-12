@extends('layouts.admin')

@section('page_title', 'Edit Kategori Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Edit Kategori Buku</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kategori-buku.update', $kategoriBuku->id_kategori) }}" method="POST" class="confirm-submit">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $kategoriBuku->kategori) }}" required>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kategori-buku.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection