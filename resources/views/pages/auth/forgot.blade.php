@extends('layouts.auth')

@section('title', 'Lupa Password | Pondok Pesantren Darul Iman')

@section('main')
    <div class="login-box text-center">
        <img src="{{ asset('img/bg/logo.png') }}" class="logo-img" alt="Logo Pesantren">
        <h5 class="mb-4 fw-bold">LUPA PASSWORD</h5>

        @if (session('status'))
            <div class="alert alert-success text-start">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3 text-start">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan email anda" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success w-100">
                Kirim Link Reset
            </button>
        </form>

        <div class="mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">&larr; Kembali ke Login</a>
        </div>
    </div>
@endsection