@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
    {{-- CSS Khusus untuk mengecilkan ukuran kalender --}}
    <style>
        .table-calendar th,
        .table-calendar td {
            padding: 0.4rem 0.2rem; /* Mengurangi padding lebih lanjut */
            font-size: 0.78rem;     /* Mengecilkan font sedikit lagi */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            {{-- Header Sambutan --}}
            <div class="section-header" style="background-color: #f6f6f6; border-radius: 8px; border-left: 4px solid #6777ef; padding: 15px 25px; margin-bottom: 30px;">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div>
                        <h4 class="mb-0">Selamat Datang, {{ Auth::user()->name }}!</h4>
                        <p class="mb-0 text-muted">Anda adalah Admin Pondok Pesantren Darul Iman</p>
                    </div>
                    <div>
                        <div class="badge badge-primary">Admin</div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                {{-- 🔹 Statistik Count --}}
                <div class="row">
                    {{-- Card Total Santri --}}
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-users fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Total Santri</div>
                                    <div class="font-weight-bold" style="font-size: 1.5rem;">28</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card Total Wali --}}
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user-graduate fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Total Wali</div>
                                    <div class="font-weight-bold" style="font-size: 1.5rem;">9</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card Total Kegiatan --}}
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-book-open fa-lg"></i>
                                </div>
                                <div>
                                    <div class="text-muted">Total Kegiatan</div>
                                    <div class="font-weight-bold" style="font-size: 1.5rem;">14</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- 🔹 Tabel Santri --}}
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Santri</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Tingkatan</th>
                                                <th>Aktifasi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $santriData = [
                                                    ['nama' => 'Nama', 'tingkatan' => 'VII', 'aktifasi' => 'Mengaji', 'status' => 'Aktif'],
                                                    ['nama' => 'Nama', 'tingkatan' => 'IV', 'aktifasi' => 'Menghafal', 'status' => 'Aktif'],
                                                    ['nama' => 'Nama', 'tingkatan' => 'III', 'aktifasi' => 'Mengaji', 'status' => 'Aktif'],
                                                    ['nama' => 'Nama', 'tingkatan' => 'VI', 'aktifasi' => 'Olah raga', 'status' => 'Aktif'],
                                                    ['nama' => 'Nama', 'tingkatan' => 'V', 'aktifasi' => 'Mengaji', 'status' => 'Aktif'],
                                                ];
                                            @endphp
                                            @foreach ($santriData as $santri)
                                            <tr>
                                                <td>
                                                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle" width="35" data-toggle="tooltip" title="{{ $santri['nama'] }}">
                                                    <span class="ml-2">{{ $santri['nama'] }}</span>
                                                </td>
                                                <td>{{ $santri['tingkatan'] }}</td>
                                                <td>{{ $santri['aktifasi'] }}</td>
                                                <td><div class="badge badge-success">{{ $santri['status'] }}</div></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 🔹 Kalender --}}
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kalender</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <a href="#" class="text-primary"><i class="fas fa-chevron-left"></i></a>
                                    <h6 class="mb-0 font-weight-bold">Agustus 2025</h6>
                                    <a href="#" class="text-primary"><i class="fas fa-chevron-right"></i></a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center table-calendar">
                                        <thead>
                                            <tr>
                                                <th>Sen</th>
                                                <th>Sel</th>
                                                <th>Rab</th>
                                                <th>Kam</th>
                                                <th>Jum</th>
                                                <th>Sab</th>
                                                <th>Min</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-muted"></td>
                                                <td class="text-muted"></td>
                                                <td class="text-muted"></td>
                                                <td class="text-muted"></td>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>5</td>
                                                <td>6</td>
                                                <td>7</td>
                                                <td>8</td>
                                                <td>9</td>
                                                <td>10</td>
                                            </tr>
                                            <tr>
                                                <td>11</td>
                                                <td>12</td>
                                                <td>13</td>
                                                <td>14</td>
                                                <td>15</td>
                                                <td>16</td>
                                                <td>17</td>
                                            </tr>
                                            <tr>
                                                <td>18</td>
                                                <td>19</td>
                                                <td>20</td>
                                                <td>21</td>
                                                <td>22</td>
                                                <td>23</td>
                                                <td>24</td>
                                            </tr>
                                            <tr>
                                                <td>25</td>
                                                <td>26</td>
                                                <td>27</td>
                                                <td>28</td>
                                                <td>29</td>
                                                <td>30</td>
                                                <td>31</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    {{-- Tidak ada script khusus yang dibutuhkan untuk halaman ini --}}
@endpush
