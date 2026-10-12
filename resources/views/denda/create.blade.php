@extends('layouts.admin')

@section('page_title', 'Tambah Denda')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Tambah Denda</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('denda.store') }}" method="POST" class="confirm-submit">
            @csrf
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal Denda</label>
                <input type="number" step="0.01" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" required min="0">
                @error('nominal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('denda.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection