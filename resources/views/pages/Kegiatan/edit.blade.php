@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Kegiatan | {{ $jadwals->Mapel->nama . ' | ' . $jadwals->Kelas->nama }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/absen') }}">Absensi</a></div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('kegiatan.update', $jadwals) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <input type="hidden" name="jadwal_id" value="{{ $jadwals->id }}">

                                <div class="form-group">
                                    <label for="image">Ganti Foto (Opsional)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
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
                                                @php
                                                    $data = $kegiatanData[$santri->id] ?? null;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <input type="hidden" name="santri_id[]"
                                                            value="{{ $santri->id }}">
                                                        {{ $santri->nama }}
                                                    </td>
                                                    <td>
                                                        <select name="jenis_kegiatan[{{ $santri->id }}]"
                                                            class="form-control">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Belajar"
                                                                {{ $data && $data->jenis_kegiatan == 'Belajar' ? 'selected' : '' }}>
                                                                Belajar</option>
                                                            <option value="Hafalan"
                                                                {{ $data && $data->jenis_kegiatan == 'Hafalan' ? 'selected' : '' }}>
                                                                Hafalan</option>
                                                            <option value="Ujian"
                                                                {{ $data && $data->jenis_kegiatan == 'Ujian' ? 'selected' : '' }}>
                                                                Ujian</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="status[{{ $santri->id }}]" class="form-control">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Hadir"
                                                                {{ $data && $data->status == 'Hadir' ? 'selected' : '' }}>
                                                                Hadir</option>
                                                            <option value="Izin"
                                                                {{ $data && $data->status == 'Izin' ? 'selected' : '' }}>
                                                                Izin</option>
                                                            <option value="Sakit"
                                                                {{ $data && $data->status == 'Sakit' ? 'selected' : '' }}>
                                                                Sakit</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="catatan[{{ $santri->id }}]"
                                                            class="form-control" value="{{ $data->catatan ?? '' }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ url('/kegiatan') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
