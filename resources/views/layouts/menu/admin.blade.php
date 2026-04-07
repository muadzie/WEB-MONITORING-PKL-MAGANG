<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Manajemen User</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.dosens.index') }}" class="nav-link {{ request()->routeIs('admin.dosens*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chalkboard-teacher"></i>
        <p>Data Dosen</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.perusahaans.index') }}" class="nav-link {{ request()->routeIs('admin.perusahaans*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Data Perusahaan</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.kelompok.index') }}" class="nav-link {{ request()->routeIs('admin.kelompok*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>Kelompok PKL</p>
    </a>
</li>

<!-- ===== MENU LAPORAN ===== -->
<li class="nav-item has-treeview {{ request()->routeIs('admin.laporan*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Laporan PKL
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Semua Laporan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan.pending') }}" class="nav-link {{ request()->routeIs('admin.laporan.pending') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Pending</p>
                @php
                    $pendingLaporan = App\Models\Laporan::where('status', 'diajukan')->count();
                @endphp
                @if($pendingLaporan > 0)
                    <span class="badge badge-warning right">{{ $pendingLaporan }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan.approved') }}" class="nav-link {{ request()->routeIs('admin.laporan.approved') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Disetujui</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.laporan.rejected') }}" class="nav-link {{ request()->routeIs('admin.laporan.rejected') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Ditolak</p>
            </a>
        </li>
    </ul>
</li>

<!-- ===== MENU REKAP DATA ===== -->
<li class="nav-item has-treeview {{ request()->routeIs('admin.rekap*') || request()->routeIs('admin.export*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
            Rekap & Export Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <!-- Submenu Rekap -->
        <li class="nav-item">
            <a href="{{ route('admin.rekap.siswa-export') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Siswa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.rekap.kelompok-export') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Kelompok</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.rekap.logbook-export') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Logbook</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.rekap.perusahaan-export') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Perusahaan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.rekap.tahunan-export') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Tahunan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.export.index') }}" class="nav-link {{ request()->routeIs('admin.export*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p><i class="fas fa-download"></i> Menu Export</p>
            </a>
        </li>
    </ul>
</li>
<!-- ===== MENU EXPORT ===== -->
<li class="nav-item">
    <a href="{{ route('admin.export.index') }}" class="nav-link {{ request()->routeIs('admin.export*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-download"></i>
        <p>Export Data</p>
    </a>
</li>