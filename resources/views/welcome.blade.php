<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Monitoring PKL - Kelola PKL dengan Mudah</title>
    
    <!-- Google Fonts - Lebih Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 (lebih modern) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Navbar Modern dengan Glassmorphism */
        .navbar-modern {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-modern.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-modern.scrolled .navbar-brand,
        .navbar-modern.scrolled .nav-link {
            color: #333 !important;
        }
        
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: white !important;
            letter-spacing: -0.5px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand i {
            color: #ffd700;
            margin-right: 10px;
            font-size: 2rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: white !important;
            margin: 0 0.8rem;
            padding: 0.5rem 0 !important;
            position: relative;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .nav-link:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #ffd700;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:before {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #ffd700 !important;
            transform: translateY(-2px);
        }
        
        .btn-login {
            background: white;
            color: #667eea !important;
            border-radius: 50px;
            padding: 0.6rem 1.8rem !important;
            font-weight: 600;
            margin-left: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: #764ba2 !important;
        }
        
        .btn-login:before {
            display: none;
        }
        
        .btn-register {
            background: transparent;
            color: white !important;
            border: 2px solid white;
            border-radius: 50px;
            padding: 0.6rem 1.8rem !important;
            font-weight: 600;
            margin-left: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            background: white;
            color: #667eea !important;
            transform: translateY(-2px);
        }
        
        .btn-register:before {
            display: none;
        }
        
        /* Hero Section */
        .hero-section {
            padding: 100px 0 80px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section:before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        .hero-section:after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .hero-image {
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Feature Cards */
        .feature-section {
            padding: 80px 0;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(5px);
            border-radius: 50px 50px 0 0;
            margin-top: 50px;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px 25px;
            color: white;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .feature-card:hover:before {
            opacity: 1;
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #ffd700;
        }
        
        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .feature-description {
            color: rgba(255,255,255,0.8);
            line-height: 1.6;
            margin-bottom: 0;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: white;
            border-radius: 50px 50px 0 0;
            margin-top: 50px;
        }
        
        .stat-card {
            text-align: center;
            padding: 30px;
            border-radius: 20px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: #666;
            font-weight: 500;
        }
        
        /* About Section */
        .about-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .about-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .about-card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }
        
        .section-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        
        .timeline-item {
            position: relative;
            padding-left: 80px;
            margin-bottom: 30px;
        }
        
        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 50px;
            height: 50px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .timeline-content {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .timeline-content h4 {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .timeline-content p {
            color: #666;
            margin-bottom: 0;
        }
        
        /* Contact Section */
        .contact-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .contact-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.2);
        }
        
        .contact-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #ffd700;
        }
        
        .contact-card h5 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .contact-card p {
            color: rgba(255,255,255,0.9);
            margin-bottom: 0;
            line-height: 1.6;
        }
        
        /* Footer */
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 60px 0 20px;
        }
        
        .footer h5 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #ffd700;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #ffd700;
            padding-left: 5px;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: #ffd700;
            color: #1a1a2e;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            color: rgba(255,255,255,0.5);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .navbar-brand {
                font-size: 1.5rem;
            }
            .btn-login, .btn-register {
                margin: 5px 0;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<!-- Navbar Modern -->
<nav class="navbar navbar-expand-lg navbar-modern fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-graduation-cap"></i>
            SISFO PKL
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-login" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-register" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center hero-content">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">
                    <i class="fas fa-rocket me-2"></i>Sistem Monitoring PKL Terintegrasi
                </span>
                <h1 class="hero-title">
                    Kelola PKL <br>dengan <span style="color: #ffd700;">Mudah & Efisien</span>
                </h1>
                <p class="hero-subtitle">
                    Platform terintegrasi untuk monitoring Praktek Kerja Lapangan. 
                    Memudahkan koordinasi antara mahasiswa, dosen, dan perusahaan dalam satu sistem.
                </p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill me-3">
                        <i class="fas fa-play me-2"></i>Mulai Sekarang
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">
                        <i class="fas fa-info-circle me-2"></i>Pelajari
                    </a>
                </div>
                <div class="mt-5">
                    <div class="row">
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">500+</h6>
                                    <small>Mahasiswa</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">50+</h6>
                                    <small>Dosen</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">100+</h6>
                                    <small>Perusahaan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <img src="https://cdn-icons-png.flaticon.com/512/2917/2917995.png" 
                     alt="Hero Image" class="img-fluid hero-image" style="max-width: 80%;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="feature-section" id="features">
    <div class="container">
        <div class="text-center text-white mb-5" data-aos="fade-up">
            <h2 class="section-title text-white">Fitur Unggulan</h2>
            <p class="section-subtitle text-white-50">Kemudahan dalam setiap proses PKL</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="feature-title">Logbook Digital</h3>
                    <p class="feature-description">Catat kegiatan PKL harian dengan mudah. Dilengkapi upload dokumentasi dan approval real-time dari dosen & PT.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="feature-title">Laporan Online</h3>
                    <p class="feature-description">Upload laporan PKL, review oleh dosen, dan tracking revisi dalam satu platform terintegrasi.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="feature-title">Penilaian Terpadu</h3>
                    <p class="feature-description">Penilaian dari dosen dan PT dengan perhitungan otomatis. Hasil nilai bisa diakses langsung oleh mahasiswa.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Multi User Role</h3>
                    <p class="feature-description">Mendukung 4 role pengguna: Admin, Dosen, PT, dan Siswa dengan fitur yang disesuaikan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="feature-title">Notifikasi Real-time</h3>
                    <p class="feature-description">Dapatkan notifikasi setiap ada logbook baru, review, atau perubahan status yang memerlukan perhatian.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="feature-title">Rekap & Analisis</h3>
                    <p class="feature-description">Lihat statistik dan rekap data PKL dalam bentuk grafik yang informatif untuk monitoring.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 mb-4" data-aos="zoom-in">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Mahasiswa Aktif</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Dosen</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Perusahaan</div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Logbook</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">Tentang Sistem</h2>
            <p class="section-subtitle">Solusi lengkap untuk monitoring PKL</p>
        </div>
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-card">
                    <h3 class="mb-4">Kenapa Memilih Sistem Kami?</h3>
                    <p class="text-muted mb-4">Sistem Monitoring PKL dikembangkan untuk memudahkan pengelolaan Praktek Kerja Lapangan di lingkungan pendidikan. Dengan sistem ini, semua proses mulai dari pendaftaran, pelaksanaan, hingga penilaian dapat terintegrasi dengan baik.</p>
                    
                    <div class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                        <div>
                            <h5>Real-time Monitoring</h5>
                            <p class="text-muted">Pantau kegiatan PKL secara real-time</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                        <div>
                            <h5>Approval 2 Level</h5>
                            <p class="text-muted">Dari dosen dan PT untuk validasi</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-3">
                        <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                        <div>
                            <h5>Export Data</h5>
                            <p class="text-muted">CSV, PDF, dan format lainnya</p>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                        <div>
                            <h5>Notifikasi Otomatis</h5>
                            <p class="text-muted">Update status via notifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-card">
                    <h3 class="mb-4">Cara Penggunaan</h3>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>1. Register Akun</h4>
                                <p>Daftar sebagai siswa, dosen, atau PT sesuai role Anda</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>2. Bergabung Kelompok</h4>
                                <p>Admin akan menempatkan Anda dalam kelompok PKL</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>3. Isi Logbook</h4>
                                <p>Catat kegiatan PKL Anda setiap hari</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>4. Upload Laporan</h4>
                                <p>Upload laporan PKL untuk direview dosen</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>5. Lihat Nilai</h4>
                                <p>Pantau nilai dari dosen dan PT</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="text-center text-white mb-5" data-aos="fade-up">
            <h2 class="section-title text-white">Hubungi Kami</h2>
            <p class="section-subtitle text-white-50">Ada pertanyaan? Kami siap membantu</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5>Alamat Kantor</h5>
                    <p>Jl. Contoh No. 123<br>Kota Contoh, 12345</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h5>Telepon</h5>
                    <p>(021) 1234-5678<br>0812-3456-7890</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5>Email</h5>
                    <p>info@monitoringpkl.ac.id<br>support@monitoringpkl.ac.id</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-graduation-cap me-2"></i>SISFO PKL</h5>
                <p class="text-white-50">Sistem Monitoring Praktek Kerja Lapangan terintegrasi untuk memudahkan pengelolaan dan monitoring kegiatan PKL.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Menu</h5>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Link Cepat</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Panduan</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Download App</h5>
                <p class="text-white-50">Akses lebih mudah dengan mobile app</p>
                <div class="d-flex">
                    <a href="#" class="me-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/888/888857.png" alt="Google Play" style="height: 40px;">
                    </a>
                    <a href="#">
                        <img src="https://cdn-icons-png.flaticon.com/512/888/888841.png" alt="App Store" style="height: 40px;">
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="mb-0">&copy; {{ date('Y') }} Sistem Monitoring PKL. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNav');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
</body>
</html>