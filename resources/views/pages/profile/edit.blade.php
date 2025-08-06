@extends('layouts.app')

@section('title', 'Edit Profil')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Profil</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profil</a></div>
                    <div class="breadcrumb-item active">Edit</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                @php
                    $kelasList = $kelasList ?? collect();
                @endphp

                <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Foto -->
                        <div class="col-lg-4">
                            <div class="card profile-widget">
                                <div class="profile-widget-header text-center">
                                    <img id="image-preview"
                                        src="{{ asset(optional(Auth::user())->image ? 'img/user/' . Auth::user()->image : 'img/avatar/avatar-1.png') }}"
                                        class="rounded-circle profile-widget-picture"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>

                                <div class="p-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror"
                                            id="file-input" name="foto" accept="image/*" onchange="previewImage()">
                                        <label class="custom-file-label" for="file-input">Pilih foto</label>
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="profile-widget-description text-center">
                                    <div class="profile-widget-name">
                                        {{ Auth::user()->email }} - {{ Auth::user()->role }}
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                    <a href="{{ route('profile.index') }}" class="btn btn-warning btn-block">Kembali</a>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Edit Akun</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Nama</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name', Auth::user()->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email', Auth::user()->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Orang Tua --}}
                                    @if (Auth::user()->role === 'Orang Tua')
                                        <hr>
                                        <h5 class="mt-4 mb-3">Data Santri</h5>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Nama</label>
                                                <input type="text" name="nama"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    value="{{ old('nama', optional(optional(Auth::user()->orangtua)->santri)->nama) }}">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir"
                                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                    value="{{ old('tanggal_lahir', optional(optional(Auth::user()->orangtua)->santri)->tanggal_lahir) }}">
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>NIS</label>
                                                <input type="text" name="nis"
                                                    class="form-control @error('nis') is-invalid @enderror"
                                                    value="{{ old('nis', optional(optional(Auth::user()->orangtua)->santri)->nis) }}">
                                                @error('nis')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control selectric">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Laki-laki"
                                                        {{ old('jenis_kelamin', optional(optional(Auth::user()->orangtua)->santri)->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="Perempuan"
                                                        {{ old('jenis_kelamin', optional(optional(Auth::user()->orangtua)->santri)->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Kelas</label>
                                                <select name="kelas_id" class="form-control selectric">
                                                    <option value="">-- Pilih Kelas --</option>
                                                    @foreach ($kelasList as $kelas)
                                                        <option value="{{ $kelas->id }}"
                                                            {{ old('kelas_id', optional(optional(Auth::user()->orangtua)->santri)->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                                            {{ $kelas->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Tanggal Masuk</label>
                                                <input type="date" name="tanggal_masuk"
                                                    class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                                    value="{{ old('tanggal_masuk', optional(optional(Auth::user()->orangtua)->santri)->tanggal_masuk) }}">
                                                @error('tanggal_masuk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>
                                        <h5 class="mt-4 mb-3">Data Orang Tua</h5>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Alamat</label>
                                                <input type="text" name="alamat"
                                                    class="form-control @error('alamat') is-invalid @enderror"
                                                    value="{{ old('alamat', optional(Auth::user()->orangtua)->alamat) }}">
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>No Telepon</label>
                                                <input type="text" name="no_telepon"
                                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                                    value="{{ old('no_telepon', optional(Auth::user()->orangtua)->no_telepon) }}">
                                                @error('no_telepon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Guru --}}
                                    @elseif (Auth::user()->role === 'Guru')
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>NIP</label>
                                                <input type="text" name="nip"
                                                    class="form-control @error('nip') is-invalid @enderror"
                                                    value="{{ old('nip', optional(Auth::user()->guru)->nip) }}">
                                                @error('nip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control selectric">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Laki-laki"
                                                        {{ old('jenis_kelamin', optional(Auth::user()->guru)->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="Perempuan"
                                                        {{ old('jenis_kelamin', optional(Auth::user()->guru)->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>No Telepon</label>
                                                <input type="text" name="no_telepon"
                                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                                    value="{{ old('no_telepon', optional(Auth::user()->guru)->no_telepon) }}">
                                                @error('no_telepon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script>
        function previewImage() {
            const fileInput = document.getElementById('file-input');
            const imagePreview = document.getElementById('image-preview');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(fileInput.files[0]);

                const label = document.querySelector("label[for='file-input']");
                if (label) label.textContent = fileInput.files[0].name;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file-input');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    const label = document.querySelector("label[for='file-input']");
                    if (label && fileInput.files[0]) label.textContent = fileInput.files[0].name;
                });
            }

            if ($.fn.selectric) {
                $('.selectric').selectric();
            }
        });
    </script>
@endpush
