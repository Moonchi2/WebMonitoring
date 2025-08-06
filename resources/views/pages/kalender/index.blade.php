@extends('layouts.app')

@section('title', 'Data Kalender')

@push('style')
    <!-- Tambahkan jika ada CSS tambahan -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            @include('layouts.alert')
            <div class="section-header">
                <h1>Data Kalender</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <form method="GET" action="{{ route('kalender.index') }}" class="form-inline mb-2 mb-md-0">
                            <div class="input-group">
                                <input type="text" name="nama" class="form-control" placeholder="Cari keterangan"
                                    value="{{ request('nama') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>

                        <a href="{{ route('kalender.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kalender
                        </a>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kalender as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $kalender->firstItem() + $index }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->tanggal_awal)->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($item->tanggal_akhir)->format('d-m-Y') }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item->keterangan, 50) }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('kalender.edit', $item) }}"
                                                    class="btn btn-sm btn-icon btn-primary m-1" data-toggle="tooltip"
                                                    title="Edit Kalender">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('kalender.show', $item->id) }}"
                                                    class="btn btn-sm btn-icon btn-info m-1" data-toggle="tooltip"
                                                    title="Edit Kalender">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('kalender.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-icon btn-danger m-1 confirm-delete"
                                                        data-toggle="tooltip" title="Hapus Kalender">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Tidak ada data kalender.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            Menampilkan {{ $kalender->firstItem() }} - {{ $kalender->lastItem() }} dari
                            {{ $kalender->total() }} data
                        </div>
                        <div>
                            {{ $kalender->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.confirm-delete');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus kalender ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush
