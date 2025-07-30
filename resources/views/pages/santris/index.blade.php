@extends('layouts.app')

@section('title', 'Santri')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/d') }}">
@endpush

@section('main')
    {{-- @if (Auth::user()->role == 'Santri') --}}
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            @include('layouts.alert')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Santri</h4>
                                </div>
                                <div class="card-body">
                                    {{-- Filter & Tambah --}}
                                    <div class="mb-3">
                                        <div class="row align-items-end">
                                            <div class="col-md-2 mb-2">
                                                <a href="{{ route('santri.create') }}" class="btn btn-primary w-100">
                                                    <i class="fas fa-plus"></i> Tambah
                                                </a>
                                            </div>
                                            <div class="col-md-10">
                                                <form action="{{ route('santri.index') }}" method="GET">
                                                    <div class="form-row row">
                                                        <div class="col-md-2 mb-2">
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <input type="text" name="name" class="form-control"
                                                                placeholder="Cari Nama santri" value="{{ request('name') }}">
                                                        </div>
                                                        <div class="col-md-1 mb-2">
                                                            <button class="btn btn-primary w-100" type="submit">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix  divider mb-3"></div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-lg" id="table-1">
                                            <tr>
                                                <th style="width: 3%">No</th>
                                                <th class="text-center">Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th style="width: 5%" class="text-center">Action</th>
                                            </tr>
                                            @foreach ($santris as $index => $santri)
                                                <tr>
                                                    <td>
                                                        {{ $santris->firstItem() + $index }}
                                                        {{ $santris->tanggal_lahir->jenis_kelamin->nis->kelas_id->tanggal_masuk->name}}\
                                                        {{ $santri->user_id->alamat->no_telepon->name}}
                                                    </td>
                                                    <td class="text-center">
                                                        <img alt="image"
                                                            src="{{ $santri->image ? asset('img/santri/' . $santri->image) : asset('img/avatar/avatar-1.png') }}"
                                                            class="rounded-circle" width="35" height="35"
                                                            data-toggle="tooltip" title="avatar">
                                                    </td>
                                                    <td>
                                                        {{ $santri->name }}
                                                    </td>
                                                    <td>
                                                        {{ $santri->email }}
                                                    </td>
                                                    <td>
                                                        {{ $santri->role }}
                                                    </td>
                                                    <td text='text-center'>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('santri.edit', $santri) }}"
                                                                class="btn btn-sm btn-icon btn-primary m-1"
                                                                data-bs-toggle="tooltip" title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                            <a href="{{ route('santri.show', $santri) }}"
                                                                class="btn btn-sm btn-icon btn-info m-1"
                                                                data-bs-toggle="tooltip" title="Lihat"><i
                                                                    class="fas fa-eye"></i></a>
                                                            <form action="{{ route('santri.destroy', $santri) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button
                                                                    class="btn btn-sm btn-icon m-1 btn-danger confirm-delete "
                                                                    data-bs-toggle="tooltip" title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        <div class="card-footer d-flex justify-content-between">
                                            <span>
                                                Showing {{ $santris->firstItem() }}
                                                to {{ $santris->lastItem() }}
                                                of {{ $santris->total() }} entries
                                            </span>
                                            <div class="paginate-sm">
                                                {{ $santris->onEachSide(0)->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    {{-- @else
        <div class="alert alert-danger">
            User role Anda tidak mendapatkan izin.
        </div>
    @endif --}}

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush