@extends('layouts.admin')

@section('page_title', 'Detail User Sistem')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail User Sistem: {{ $user->nama_user }}</h4>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID User:</strong> {{ $user->id_user }}
        </div>
        <div class="mb-3">
            <strong>Username:</strong> {{ $user->nama_user }}
        </div>
        <div class="mb-3">
            <strong>Nama Lengkap:</strong> {{ $user->full_name }}
        </div>
        <div class="mb-3">
            <strong>Role:</strong> {{ ucfirst($user->role) }}
        </div>
        <div class="mb-3">
            <strong>Dibuat Pada:</strong> {{ $user->created_at->format('d M Y, H:i') }}
        </div>
        <div class="mb-3">
            <strong>Diperbarui Pada:</strong> {{ $user->updated_at->format('d M Y, H:i') }}
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection