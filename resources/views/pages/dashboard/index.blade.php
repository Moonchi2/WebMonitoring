@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.css" />
    <style>
        .welcome-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
            flex-wrap: wrap;
        }

        .welcome-card img {
            max-width: 120px;
        }

        .jadwal-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        @media (max-width: 576px) {
            .welcome-card img {
                max-width: 80px;
            }

            .jadwal-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .jadwal-card .d-flex {
                flex-direction: column;
                gap: 1rem;
            }

            .jadwal-card .text-right {
                text-align: left !important;
            }
        }

        .calendar-container {
            margin-bottom: 1rem;
            overflow-x: auto;
        }

        .keterangan-box {
            background: #f4f4f4;
            padding: 1rem;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .keterangan-item {
            margin-bottom: 0.75rem;
        }

        .kegiatan-title {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .fc .fc-toolbar-title {
                font-size: 1.1rem;
            }

            .fc-toolbar.fc-header-toolbar {
                flex-direction: column;
                gap: 0.5rem;
            }

            .fc .fc-button {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }

            .fc .fc-daygrid-day-number {
                font-size: 0.75rem;
            }

            .calendar-container {
                overflow-x: auto;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            @if (Auth::user()->role == 'Admin')
                <div class="row">
                    <!-- Statistik Cards -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary"><i class="fas fa-users"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Jumlah User</h4>
                                </div>
                                <div class="card-body">{{ $jumlah_user }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success"><i class="fas fa-chalkboard-teacher"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Jumlah Guru</h4>
                                </div>
                                <div class="card-body">{{ $jumlah_guru }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning"><i class="fas fa-user-graduate"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Jumlah Santri</h4>
                                </div>
                                <div class="card-body">{{ $jumlah_santri }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger"><i class="fas fa-book"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Jumlah Mapel</h4>
                                </div>
                                <div class="card-body">{{ $jumlah_mapel }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <!-- Jadwal Hari Ini -->
                <div class="col-md-8">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                @php $role = Auth::user()->role; @endphp
                                <h4 class="mb-2">
                                    @if ($role == 'Admin')
                                        Daftar Jadwal
                                    @elseif($role == 'Guru')
                                        Jadwal Mengajar
                                    @else
                                        Jadwal Pelajaran
                                    @endif
                                </h4>
                                <form method="GET" class="form-inline">
                                    <label for="hari" class="mr-2">Hari:</label>
                                    <select name="hari" id="hari" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">Semua</option>
                                        @foreach ($daftar_hari as $hari)
                                            <option value="{{ $hari }}"
                                                {{ $filterHari == $hari ? 'selected' : '' }}>
                                                {{ ucfirst($hari) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            @if ($jadwal->isEmpty())
                                <div class="alert alert-info">Tidak ada jadwal untuk hari
                                    ini{{ $filterHari ? " ($filterHari)" : '' }}.
                                </div>
                            @else
                                @foreach ($jadwal as $item)
                                    @php
                                        $hariMap = [
                                            'Senin' => 0,
                                            'Selasa' => 1,
                                            'Rabu' => 2,
                                            'Kamis' => 3,
                                            'Jumat' => 4,
                                            'Sabtu' => 5,
                                            'Minggu' => 6,
                                        ];
                                        $indexHari = $hariMap[$item->hari] ?? 0;
                                        $tanggalPertemuan = \Carbon\Carbon::now()
                                            ->startOfWeek()
                                            ->addDays($indexHari)
                                            ->format('d-m-Y');
                                    @endphp

                                    <div class="jadwal-card">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <h5>{{ strtoupper(optional($item->mapel)->nama) }}</h5>
                                                <p><i class="fas fa-calendar-day"></i> Hari: {{ ucfirst($item->hari) }}</p>
                                                <p><i class="fas fa-clock"></i> {{ $item->jam_mulai }} -
                                                    {{ $item->jam_selesai }} WIB
                                                </p>
                                                <p><i class="fas fa-users"></i> Kelas {{ optional($item->kelas)->nama }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p><i class="fas fa-calendar"></i> Tanggal: {{ $tanggalPertemuan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- PAGINATION --}}
                                <div class="mt-3">
                                    {{ $jadwal->appends(request()->query())->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kalender -->
                <div class="col-md-4">
                    <div class="card card-custom">
                        <div class="card-header">
                            <h6 class="text-success m-0">Kalender Kegiatan</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="calendar-container" id="calendar"></div>

                            <div id="eventDetails" class="keterangan-box d-none mt-3">
                                <h5 class="kegiatan-title">Keterangan Kalender</h5>
                                <div id="keteranganContent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const keteranganBox = document.getElementById('eventDetails');
            const keteranganContent = document.getElementById('keteranganContent');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                events: {!! json_encode(
                    $kalender->map(function ($item) {
                        return [
                            'title' => $item->kegiatan ?? 'Kegiatan',
                            'start' => $item->tanggal_awal,
                            'end' => \Carbon\Carbon::parse($item->tanggal_akhir)->addDay()->toDateString(),
                            'extendedProps' => [
                                'keterangan' => nl2br(e($item->keterangan)),
                                'kegiatan' => $item->kegiatan,
                            ],
                        ];
                    }),
                ) !!},
                eventClick: function(info) {
                    const keterangan = info.event.extendedProps.keterangan || '-';
                    const kegiatan = info.event.extendedProps.kegiatan || info.event.title;

                    keteranganContent.innerHTML = `
                    <p><strong>Kegiatan:</strong> ${kegiatan}</p>
                    <p><strong>Keterangan:</strong><br>${keterangan}</p>
                `;
                    keteranganBox.classList.remove('d-none');
                },
                dateClick: function(info) {
                    const clickedDate = info.dateStr;

                    // Ambil semua event dari kalender
                    const matchedEvents = calendar.getEvents().filter(event => {
                        const start = event.startStr;
                        const end = event.endStr || start;
                        return clickedDate >= start && clickedDate < end;
                    });

                    if (matchedEvents.length > 0) {
                        let content = '';
                        matchedEvents.forEach(event => {
                            const kegiatan = event.extendedProps.kegiatan || event.title;
                            const keterangan = event.extendedProps.keterangan || '-';

                            content += `
                            <div class="keterangan-item">
                                <p><strong>Kegiatan:</strong> ${kegiatan}</p>
                                <p><strong>Keterangan:</strong><br>${keterangan}</p>
                                <hr>
                            </div>
                        `;
                        });
                        keteranganContent.innerHTML = content;
                        keteranganBox.classList.remove('d-none');
                    } else {
                        keteranganBox.classList.add('d-none');
                    }
                }
            });

            calendar.render();
        });
    </script>
@endpush
