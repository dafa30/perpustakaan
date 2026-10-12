@extends('layouts.admin')

@section('page_title', 'Detail Denda')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Denda: Rp {{ number_format($denda->nominal, 2, ',', '.') }}</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID Denda:</strong> {{ $denda->id_denda }}
        </div>
        <div class="mb-3">
            <strong>Nominal:</strong> Rp {{ number_format($denda->nominal, 2, ',', '.') }}
        </div>
        <div class="mb-3">
            <strong>Dibuat Pada:</strong> {{ $denda->created_at->format('d M Y, H:i') }}
        </div>
        <div class="mb-3">
            <strong>Diperbarui Pada:</strong> {{ $denda->updated_at->format('d M Y, H:i') }}
        </div>
        <a href="{{ route('denda.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('denda.edit', $denda->id_denda) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection