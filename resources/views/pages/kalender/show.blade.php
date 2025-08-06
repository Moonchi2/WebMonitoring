@extends('layouts.app')

@section('title', 'Detail Kalender')

@push('style')
    <!-- Tambahkan CSS jika perlu -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Kalender</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Tanggal </label>
                        <p>{{ \Carbon\Carbon::parse($kalender->tanggal_awal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($kalender->tanggal_akhir)->translatedFormat('d F Y') }}</p>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <p>{{ $kalender->keterangan }}</p>
                    </div>

                    <a href="{{ route('kalender.index') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </section>
    </div>
@endsection
