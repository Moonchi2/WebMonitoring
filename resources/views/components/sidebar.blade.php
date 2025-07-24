<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Customer')
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
                    <a href="{{ route('dashboard.index') }}" class="nav-link ha">
                        <i class="fas fa-home"></i><span>Dashboard</span>
                    </a>
                </li>

                {{-- @if (Auth::user()->role == 'Guru') --}}
                    <li class="nav-item dropdown {{ $type_menu === 'kegiatan' ? 'active' : '' }}">
                        <a href="{{ route('kegiatan.index') }}" class="nav-link ha">
                            <i class="fas fa-user-cog"></i><span>kegiatan</span>
                        </a>
                    </li>
                    {{-- @endif --}}

                <li class="menu-header">Master Data</li>
                {{-- Users (Admin only) --}}
                @if (Auth::user()->role == 'Admin')
                    <li class="nav-item dropdown {{ $type_menu === 'user' ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="nav-link ha">
                            <i class="fas fa-user-cog"></i><span>Users</span>
                        </a>
                    </li>
                @endif
            </ul>
        @else
            <div class="alert alert-danger">
                User role Anda tidak mendapatkan izin.
            </div>
        @endif
    </aside>
</div>