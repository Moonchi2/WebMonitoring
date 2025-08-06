@extends('layouts.app')

@section('title', 'Profile')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card profile-widget">
                            <div class="profile-widget-header text-center">
                                <img src="{{ asset(optional(Auth::user())->image ? 'img/user/' . Auth::user()->image : 'img/avatar/avatar-1.png') }}"
                                     class="rounded-circle profile-widget-picture"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            </div>

                            <div class="card-body text-center">
                                <h5>{{ Auth::user()->name }}</h5>
                                <p class="text-muted">{{ Auth::user()->email }} - {{ Auth::user()->role }}</p>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('profile.edit', Auth::user()->id) }}" class="btn btn-primary btn-block">Edit Profil</a>
                                <a href="{{ route('profile.change-password-form', Auth::user()->id) }}" class="btn btn-warning btn-block">Ganti Password</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Akun</h4>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width:30%">Nama</th>
                                            <td>{{ Auth::user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ Auth::user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>{{ Auth::user()->role }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                {{-- Data khusus role Orang Tua --}}
                                @if (Auth::user()->role === 'Orang Tua')
                                    <div class="mt-4">
                                        <h5>Data Santri</h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Nama</th>
                                                    <td>{{ optional(optional(Auth::user()->orangtua)->santri)->nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>NIS</th>
                                                    <td>{{ optional(optional(Auth::user()->orangtua)->santri)->nis ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Lahir</th>
                                                    <td>{{ optional(optional(Auth::user()->orangtua)->santri)->tanggal_lahir ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <td>{{ optional(optional(Auth::user()->orangtua)->santri)->tanggal_masuk ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kelas</th>
                                                    <td>{{ optional(optional(optional(Auth::user()->orangtua)->santri)->kelas)->nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Kelamin</th>
                                                    <td>{{ optional(optional(Auth::user()->orangtua)->santri)->jenis_kelamin ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <h5 class="mt-4">Data Orang Tua</h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>{{ optional(Auth::user()->orangtua)->alamat ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>No HP</th>
                                                    <td>{{ optional(Auth::user()->orangtua)->no_telepon ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                {{-- Data khusus role Guru --}}
                                @elseif (Auth::user()->role === 'Guru')
                                    <div class="mt-4">
                                        <h5>Data Guru</h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>NIP</th>
                                                    <td>{{ optional(Auth::user()->guru)->nip ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Kelamin</th>
                                                    <td>{{ optional(Auth::user()->guru)->jenis_kelamin ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>No HP</th>
                                                    <td>{{ optional(Auth::user()->guru)->no_telepon ?? '-' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
