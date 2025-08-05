@extends('layouts.app')

@section('title', 'Edit Kelas')

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 300px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Kelas</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            @include('layouts.alert')

                            <div class="form-group">
                                <label>Nama Kelas</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ old('nama', $kelas->nama) }}" required>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('kelas.index') }}" class="btn btn-warning">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var currentLat = parseFloat(document.getElementById('latitude').value);
        var currentLng = parseFloat(document.getElementById('longitude').value);

        var map = L.map('map').setView([currentLat, currentLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([currentLat, currentLng], {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(e) {
            var latlng = marker.getLatLng();
            document.getElementById('latitude').value = latlng.lat.toFixed(6);
            document.getElementById('longitude').value = latlng.lng.toFixed(6);
        });

        function updateMarker() {
            var lat = parseFloat(document.getElementById('latitude').value);
            var lng = parseFloat(document.getElementById('longitude').value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 13);
            }
        }

        document.getElementById('latitude').addEventListener('change', updateMarker);
        document.getElementById('longitude').addEventListener('change', updateMarker);
    </script>
@endpush
