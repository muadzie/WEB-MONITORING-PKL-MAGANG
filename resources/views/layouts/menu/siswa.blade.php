<li class="nav-item">
    <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('siswa.profile.edit') }}" class="nav-link {{ request()->routeIs('siswa.profile*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Profile Saya</p>
    </a>

<li class="nav-item">
    <a href="{{ route('siswa.logbook.index') }}" class="nav-link {{ request()->routeIs('siswa.logbook*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Logbook Kegiatan
            @php
                $pendingCount = 0;
                if(Auth::check() && Auth::user()->kelompokSiswa()->exists()) {
                    $kelompokSiswaId = Auth::user()->kelompokSiswa()->first()->id;
                    $pendingCount = App\Models\Logbook::where('kelompok_siswa_id', $kelompokSiswaId)
                                      ->where('status', 'pending')
                                      ->count();
                }
            @endphp
            @if($pendingCount > 0)
                <span class="badge badge-warning right">{{ $pendingCount }}</span>
            @endif
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('siswa.laporan.index') }}" class="nav-link {{ request()->routeIs('siswa.laporan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Upload Laporan</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('siswa.penilaian.index') }}" class="nav-link {{ request()->routeIs('siswa.penilaian*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>Nilai PKL</p>
    </a>
</li>


</li>