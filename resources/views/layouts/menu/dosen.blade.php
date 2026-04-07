<li class="nav-item">
    <a href="{{ route('dosen.dashboard') }}" class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.bimbingan.index') }}" class="nav-link {{ request()->routeIs('dosen.bimbingan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Kelompok Bimbingan</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.logbook.pending') }}" class="nav-link {{ request()->routeIs('dosen.logbook*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Logbook Perlu Review
            @php
                $pendingCount = App\Models\Logbook::whereHas('kelompokSiswa.kelompok', function($q) {
                    $q->where('dosen_id', Auth::user()->dosen->id ?? 0);
                })->where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="badge badge-warning right">{{ $pendingCount }}</span>
            @endif
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.absensi.siswa') }}" class="nav-link {{ request()->routeIs('dosen.absensi*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-fingerprint"></i>
        <p>Absensi & Rekap</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.ijin-sakit.index') }}" class="nav-link {{ request()->routeIs('dosen.ijin-sakit*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-medical"></i>
        <p>Izin / Sakit</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.laporan.index') }}" class="nav-link {{ request()->routeIs('dosen.laporan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Review Laporan
            @php
                $laporanCount = App\Models\Laporan::whereHas('kelompokSiswa.kelompok', function($q) {
                    $q->where('dosen_id', Auth::user()->dosen->id ?? 0);
                })->whereIn('status', ['diajukan', 'direvisi'])->count();
            @endphp
            @if($laporanCount > 0)
                <span class="badge badge-warning right">{{ $laporanCount }}</span>
            @endif
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.penilaian.index') }}" class="nav-link {{ request()->routeIs('dosen.penilaian*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>Penilaian</p>
    </a>
</li>


<!-- ========== MENU ABSENSI (DROPDOWN) ========== -->
<li class="nav-item has-treeview {{ request()->routeIs('dosen.absensi*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-fingerprint"></i>
        <p>
            Absensi & Rekap
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('dosen.absensi.siswa') }}" class="nav-link {{ request()->routeIs('dosen.absensi.siswa') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Absen Siswa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dosen.absensi.rekap') }}" class="nav-link {{ request()->routeIs('dosen.absensi.rekap') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rekap Absensi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dosen.absensi.export-excel') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p><i class="fas fa-file-excel text-success"></i> Download detail</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dosen.absensi.export-rekap-siswa') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p><i class="fas fa-chart-bar text-info"></i>Rekap per Siswa</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('dosen.ijin-sakit.index') }}" class="nav-link {{ request()->routeIs('dosen.ijin-sakit*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-medical"></i>
        <p>Izin / Sakit</p>
    </a>
</li>