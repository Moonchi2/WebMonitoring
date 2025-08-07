@extends('layouts.app')

@section('title', 'Kegiatan')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kegiatan | {{ $jadwals->Mapel->nama . ' | ' . $jadwals->Kelas->nama }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/absen') }}">Absensi</a></div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('kegiatan.store', $jadwals) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <input type="hidden" name="jadwal_id" value="{{ $jadwals->id }}">

                                <div class="form-group">
                                    <label for="image">Upload Foto Kegiatan</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Santri</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($santris as $santri)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input type="hidden" name="santri_id[]"
                                                            value="{{ $santri->id }}">
                                                        {{ $santri->nama }}
                                                    </td>
                                                    <td>
                                                        <select class="form-control"
                                                            name="jenis_kegiatan[{{ $santri->id }}]">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Belajar">Belajar</option>
                                                            <option value="Hafalan">Hafalan</option>
                                                            <option value="Ujian">Ujian</option>
                                                        </select>
                                                        @error("jenis_kegiatan.{$santri->id}")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="status[{{ $santri->id }}]">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Hadir">Hadir</option>
                                                            <option value="Izin">Izin</option>
                                                            <option value="Sakit">Sakit</option>
                                                        </select>
                                                        @error("status.{$santri->id}")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="catatan[{{ $santri->id }}]"
                                                            value="{{ old('catatan.' . $santri->id) }}"
                                                            placeholder="Masukkan catatan (opsional)">
                                                        @error("catatan.{$santri->id}")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ url('/kegiatan') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush
