@extends('layouts.auth')

@section('title', 'Reset Password | Pondok Pesantren Darul Iman')

@section('main')
    <div class="login-box text-center">
        <img src="{{ asset('img/logo.png') }}" class="logo-img" alt="Logo Pesantren">
        <h5 class="mb-4 fw-bold">RESET PASSWORD</h5>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3 text-start">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email" value="{{ old('email', $email) }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password Baru" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password"
                    required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Reset Password
            </button>
        </form>
    </div>
@endsection