@extends('layouts.app')

@section('content')
<div class="card shadow-lg p-4">
    <div class="card-header text-center bg-white border-0 pb-0">
        <h2 class="h3 fw-bold text-primary">{{ __('Register') }}</h2>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">{{ __('Nama Lengkap') }}</label>
                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required autocomplete="name">
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_user" class="form-label">{{ __('Username') }}</label>
                <input id="nama_user" type="text" class="form-control @error('nama_user') is-invalid @enderror" name="nama_user" value="{{ old('nama_user') }}" required autocomplete="username">
                @error('nama_user')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Password') }}</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>

            <hr class="my-4">
            <p class="text-center mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </form>
    </div>
</div>
@endsection