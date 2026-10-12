@extends('layouts.app')

@section('content')
<div class="card shadow-lg p-4">
    <div class="card-header text-center bg-white border-0 pb-0">
        <h2 class="h3 fw-bold text-primary">{{ __('Login') }}</h2>
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="nama_user" class="form-label">{{ __('Username') }}</label>
                <input id="nama_user" type="text" class="form-control @error('nama_user') is-invalid @enderror" name="nama_user" value="{{ old('nama_user') }}" required autocomplete="nama_user">
                @error('nama_user')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>

            <hr class="my-4">
            <p class="text-center mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </form>
    </div>
</div>
@endsection