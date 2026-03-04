<li class="nav-item">
    <a href="{{ route('pt.dashboard') }}" class="nav-link {{ request()->routeIs('pt.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pt.monitoring.index') }}" class="nav-link {{ request()->routeIs('pt.monitoring*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Monitoring Siswa</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pt.logbook.index') }}" class="nav-link {{ request()->routeIs('pt.logbook*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Logbook
            @php
                $pendingCount = 0;
                $user = Auth::user();
                if ($user && $user->perusahaan) {
                    $pendingCount = App\Models\Logbook::whereHas('kelompokSiswa.kelompok', function($q) use ($user) {
                        $q->where('perusahaan_id', $user->perusahaan->id);
                    })->where('status', 'pending')->count();
                }
            @endphp
            @if($pendingCount > 0)
                <span class="badge badge-warning right">{{ $pendingCount }}</span>
            @endif
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('pt.penilaian.index') }}" class="nav-link {{ request()->routeIs('pt.penilaian*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>Penilaian</p>
    </a>
</li>