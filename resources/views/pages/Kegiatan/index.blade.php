@extends('layouts.app')

@section('title', 'Activity')

@section('content')
<div class="p-6">
    {{-- Greeting Box --}}
    <div class="bg-white border-l-4 border-green-600 p-4 rounded shadow mb-6">
        <h2 class="font-semibold text-lg text-gray-800">Selamat Datang, {{ Auth::user()->name ?? 'Monika' }}!</h2>
        <p class="text-sm text-gray-600">Anda adalah Admin Pondok Pesantren Darul Iman</p>
    </div>

    {{-- Jadwal Section --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-semibold text-green-800 border-b-2 border-green-700 inline-block">Jadwal Mengajar</h3>
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 7V3M16 7V3M4 11H20M5 19H19A1 1 0 0020 18V8A1 1 0 0019 7H5a1 1 0 00-1 1v10a1 1 0 001 1z" />
                </svg>
                Senin, 13 Mei 2024
            </div>
        </div>

        {{-- Card Jadwal --}}
        @foreach ($jadwal as $item)
        <div class="border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-xl font-bold text-green-900 uppercase">{{ $item['mapel'] }}</h4>
                    <ul class="text-sm text-gray-700 mt-2 space-y-1">
                        <li><i class="far fa-clock mr-2"></i>{{ $item['waktu'] }} WIB</li>
                        <li><i class="far fa-user mr-2"></i>{{ $item['jumlah_murid'] }} Murid</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>{{ $item['kelas'] }}</li>
                    </ul>
                </div>
                <div class="text-right">
                    <span class="text-sm text-gray-600 flex items-center justify-end mb-2">
                        <i class="fas fa-book mr-1"></i>Pertemuan ke {{ $item['pertemuan'] }}
                    </span>
                    <button class="border border-gray-400 text-sm px-3 py-1 rounded hover:bg-gray-100">Generate Kode QR</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
