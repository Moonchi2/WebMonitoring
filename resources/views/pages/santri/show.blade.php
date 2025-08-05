@extends('layouts.app')

@section('title', 'Detail Santri')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Santri</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Santri</h4>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama</dt>
                            <dd class="col-sm-8">{{ $santri->nama }}</dd>

                            <dt class="col-sm-4">NIS</dt>
                            <dd class="col-sm-8">{{ $santri->nis }}</dd>

                            <dt class="col-sm-4">Kelas</dt>
                            <dd class="col-sm-8">{{ $santri->kelas->nama }}</dd>

                            <dt class="col-sm-4">Jenis Kelamin</dt>
                            <dd class="col-sm-8">{{ $santri->jenis_kelamin }}</dd>

                            <dt class="col-sm-4">Tanggal Lahir</dt>
                            <dd class="col-sm-8">{{ $santri->tanggal_lahir }}</dd>

                            <dt class="col-sm-4">Tanggal Masuk</dt>
                            <dd class="col-sm-8">{{ $santri->tanggal_masuk }}</dd>
                        </dl>
                    </div>
                </div>

                @if ($ortu)
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Orang Tua</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">{{ $ortu->nama }}</dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">{{ $ortu->alamat }}</dd>

                                <dt class="col-sm-4">No Telepon</dt>
                                <dd class="col-sm-8">{{ $ortu->no_telepon }}</dd>
                            </dl>
                        </div>
                    </div>
                @endif

                <a href="{{ route('santri.index') }}" class="btn btn-warning mt-3">Kembali</a>
            </div>
        </section>
    </div>
@endsection
