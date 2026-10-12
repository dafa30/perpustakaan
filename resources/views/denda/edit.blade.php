@extends('layouts.admin')

@section('page_title', 'Edit Denda')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Edit Denda</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('denda.update', $denda->id_denda) }}" method="POST" class="confirm-submit">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal Denda</label>
                <input type="number" step="0.01" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal', $denda->nominal) }}" required min="0">
                @error('nominal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('denda.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection