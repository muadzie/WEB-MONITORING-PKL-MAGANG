<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Monitoring PKL') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="https://c.top4top.io/p_3749c8ad71.png">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    @stack('styles')
    @push('styles')
<style>
    

    .profile-user-img {
        width: 120px !important;
        height: 120px !important;
        min-width: 120px !important;
        min-height: 120px !important;
        max-width: 120px !important;
        max-height: 120px !important;
        object-fit: cover !important;
        border-radius: 50% !important;
        box-shadow: 0 0 15px rgba(0,0,0,0.1) !important;
        display: block !important;
        margin: 0 auto !important;
    }
</style>
@endpush
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
           <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @php
            $notifUnread = 0;
            if(Auth::check() && method_exists(Auth::user(), 'notifikasis')) {
                $notifUnread = Auth::user()->notifikasis()->unread()->count();
            }
        @endphp
        @if($notifUnread > 0)
            <span class="badge badge-warning navbar-badge">{{ $notifUnread }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $notifUnread }} Notifikasi Baru</span>
        <div class="dropdown-divider"></div>
        @if(Auth::check() && method_exists(Auth::user(), 'notifikasis'))
            @foreach(Auth::user()->notifikasis()->unread()->latest()->take(5)->get() as $notif)
                <a href="{{ $notif->url ?? '#' }}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>
                    <span class="text-{{ $notif->tipe }}">{{ $notif->judul }}</span>
                    <span class="float-right text-muted text-sm">{{ $notif->created_at->diffForHumans() }}</span>
                </a>
                <div class="dropdown-divider"></div>
            @endforeach
        @endif
        <a href="{{ route('notifikasi.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
    </div>
</li>
           <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user"></i> {{ Auth::user()->name }}
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('profile.edit') }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil Saya
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">SISFO PKL</span>
        </a>

        <div class="sidebar">
           <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        @if(Auth::user()->foto)
            <img src="{{ asset('storage/'.Auth::user()->foto) }}" class="profile-user-img img-fluid img-circle" alt="User Image" style="width: 50px; height: 50px; min-width: 50px; min-height: 50px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;  box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        @else
            <div class="default-avatar img-circle elevation-2 d-flex align-items-center justify-content-center" 
                 style="width: 34px; height: 34px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 18px; font-weight: bold;">
                <i class="fas fa-user"></i>
            </div>
        @endif
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        <small class="text-white">{{ ucfirst(Auth::user()->role) }}</small>
    </div>
</div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    @if(Auth::user()->role == 'admin')
                        @include('layouts.menu.admin')
                    @elseif(Auth::user()->role == 'dosen')
                        @include('layouts.menu.dosen')
                    @elseif(Auth::user()->role == 'pt')
                        @include('layouts.menu.pt')
                    @elseif(Auth::user()->role == 'siswa')
                        @include('layouts.menu.siswa')
                    @endif
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; {{ date('Y') }} SISFO PKL. By Ilham Mu'adz Fakhrizi and Tim❤️.</strong>
    </footer>
</div>

<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('scripts')
</body>
</html>