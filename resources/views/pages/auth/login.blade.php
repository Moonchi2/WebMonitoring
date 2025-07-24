@extends('layouts.auth')

@section('title', 'Login | Pondok Pesantren Darul Iman')

@section('main')
    <div class="login-box text-center">
        <img src="{{ asset('img/bg/logo.png') }}" class="logo-img" alt="Logo Pesantren">
        <p class="mb-1 text-muted">SELAMAT DATANG!</p>
        <h5 class="mb-4 fw-bold">PONDOK PESANTREN DARUL IMAN</h5>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 text-start">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Masuk
            </button>
        </form>

        <div class="mt-3">
            <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #3B82F6;">
                Lupa Password?
            </a>
        </div>
    </div>
@endsection