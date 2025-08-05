@extends('layouts.app')

@section('title', 'Data Santri')

@push('style')
    <!-- Tambahkan CSS jika diperlukan -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            @include('layouts.alert')

            <div class="section-header">
                <h1>Data Santri</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <form method="GET" action="{{ route('santri.index') }}" class="form-inline">
                            <div class="input-group mr-2">
                                <select name="kelas" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($listKelas as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $kelas->id == $kelasId ? 'selected' : '' }}>
                                            {{ $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama santri"
                                    value="{{ $keyword }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            @if ($keyword || $kelasId)
                                <a href="{{ route('santri.index') }}" class="btn btn-warning ml-2">Reset</a>
                            @endif
                        </form>

                        <a href="{{ route('santri.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Santri
                        </a>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($santris as $index => $santri)
                                    <tr>
                                        <td>{{ $santris->firstItem() + $index }}</td>
                                        <td>{{ $santri['nama'] ?? '-' }}</td>
                                        <td>{{ $santri['kelas']['nama'] ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('santri.edit', $santri['id']) }}"
                                                    class="btn btn-sm btn-icon btn-primary m-1" data-toggle="tooltip"
                                                    title="Edit santri">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ route('santri.show', $santri['id']) }}"
                                                    class="btn btn-sm btn-icon btn-info m-1" data-toggle="tooltip"
                                                    title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <form action="{{ route('santri.destroy', $santri['id']) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-icon btn-danger m-1"
                                                        data-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            @if ($keyword || $kelasId)
                                                Tidak ditemukan santri dengan filter yang diberikan.
                                            @else
                                                Tidak ada data santri.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            Menampilkan {{ $santris->firstItem() ?? 0 }} - {{ $santris->lastItem() ?? 0 }} dari
                            {{ $santris->total() }} data
                        </div>
                        <div>
                            {{ $santris->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
