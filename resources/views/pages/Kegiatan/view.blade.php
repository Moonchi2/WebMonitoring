@extends('layouts.app')

@section('title', 'Lihat Kegiatan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h1>Lihat Kegiatan</h1>
                <a href="{{ url()->previous() }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Mata Pelajaran:</strong> {{ $kegiatan->jadwal->mapel->nama ?? '-' }}</p>
                        <p><strong>Kelas:</strong> {{ $kegiatan->jadwal->kelas->nama ?? '-' }}</p>
                        <p><strong>Hari:</strong> {{ $kegiatan->jadwal->hari }}</p>
                        <p><strong>Tanggal Kegiatan:</strong>
                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->translatedFormat('d F Y') }}</p>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Santri</th>
                                    <th>Status Kehadiran</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Catatan</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarKegiatan as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->santri->nama ?? '-' }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->jenis_kegiatan ?? '-' }}</td>
                                        <td>{{ $item->catatan ?? '-' }}</td>
                                        <td class="text-center">
                                            @if ($item->image)
                                                <img src="{{ asset('img/kegiatan/' . $item->image) }}" alt="Gambar"
                                                    width="80" height="60" class="img-thumbnail"
                                                    style="cursor:pointer" data-toggle="modal" data-target="#imageModal"
                                                    data-image="{{ asset('img/kegiatan/' . $item->image) }}">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data kehadiran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal Preview Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="" id="previewImage" class="img-fluid rounded" alt="Preview Gambar">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewImage = document.getElementById('previewImage');

            document.querySelectorAll('[data-toggle="modal"]').forEach(function(thumbnail) {
                thumbnail.addEventListener('click', function() {
                    const imageUrl = this.getAttribute('data-image');
                    previewImage.src = imageUrl;
                });
            });
        });
    </script>
@endpush
