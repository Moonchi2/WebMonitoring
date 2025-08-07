@extends('layouts.app')

@section('title', 'Edit Kalender')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Kalender</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('kalender.update', $kalender->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            @include('layouts.alert')
                            <div class="form-group">
                                <label for="kegiatan">Nama Kegiatan</label>
                                <input type="text" name="kegiatan" class="form-control" value="{{ old('kegiatan', $kalender->tanggal_awal) }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal" class="form-control"
                                    value="{{ old('tanggal_awal', $kalender->tanggal_awal) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control"
                                    value="{{ old('tanggal_akhir', $kalender->tanggal_akhir) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $kalender->keterangan) }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('kalender.index') }}" class="btn btn-warning">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
