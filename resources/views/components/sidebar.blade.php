<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        @php
            $role = Auth::user()->role;
        @endphp

        @if ($role == 'Admin' || $role == 'Customer')
            <div class="sidebar-brand">
                <a href="{{ route('dashboard.index') }}">
                    <img src="{{ asset('img/logo/logo_nama.png') }}" alt="Logo" style="width: 170px; height: auto;">
                </a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="{{ route('dashboard.index') }}">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" style="width: 40px; height: auto;">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-header">Master Data</li>
                <li class="nav-item dropdown {{ $type_menu === 'kegiatan' ? 'active' : '' }}">
                    <a href="{{ route('kegiatan.index') }}" class="nav-link">
                        <i class="fas fa-tasks"></i><span>Kegiatan</span>
                    </a>
                </li>

                <li class="nav-item dropdown {{ $type_menu === 'kelola' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-calendar-alt"></i><span>Kelola Kegiatan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('guru*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('guru.index') }}">
                                <i class="fas fa-chalkboard-teacher mr-1"></i>Guru
                            </a>
                        </li>
                        <li class="{{ Request::is('jadwal*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('jadwal.index') }}">
                                <i class="fas fa-clock mr-1"></i>Jadwal
                            </a>
                        </li>
                        <li class="{{ Request::is('kelas*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kelas.index') }}">
                                <i class="fas fa-door-open mr-1"></i>Kelas
                            </a>
                        </li>
                        <li class="{{ Request::is('matapelajaran*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('matapelajaran.index') }}">
                                <i class="fas fa-book mr-1"></i>Mata Pelajaran
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown {{ $type_menu === 'santris' ? 'active' : '' }}">
                    <a href="{{ route('santris.index') }}" class="nav-link">
                        <i class="fas fa-user-graduate"></i><span>Kelola Santri</span>
                    </a>
                </li>

                @if ($role === 'Admin')
                    <li class="nav-item dropdown {{ $type_menu === 'user' ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="fas fa-users-cog"></i><span>Users</span>
                        </a>
                    </li>
                @endif
            </ul>
        @else
            <div class="alert alert-danger m-3">
                <strong>Access Denied:</strong> Anda tidak memiliki izin untuk mengakses menu ini.
            </div>
        @endif
    </aside>
</div>
