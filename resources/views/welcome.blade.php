<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISFO PKL - Platform Monitoring PKL Modern</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f8fafc;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: var(--white);
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .navbar-brand i {
            color: var(--secondary);
            margin-right: 0.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            margin: 0 0.5rem;
            transition: color 0.2s;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero */
        .hero {
            padding: 8rem 0 5rem;
            background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
        }
        
        .hero-title {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }
        
        .hero-title span {
            color: var(--primary);
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            color: var(--gray);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .hero-stat h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0;
        }
        
        .hero-stat p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .hero-image {
            text-align: right;
        }
        .hero-image img {
            animation: floatImage 4s ease-in-out infinite;
            max-width: 85%;
            display: inline-block;
            transform: translateX(-20px);
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
        }
        
        @keyframes floatImage {
            0% { transform: translateY(0px) translateX(-20px); }
            50% { transform: translateY(-15px) translateX(-20px); }
            100% { transform: translateY(0px) translateX(-20px); }
        }
        
        /* Feature Cards */
        .section-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        .section-subtitle {
            text-align: center;
            color: var(--gray);
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }
        
        .feature-card {
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 2rem;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1);
            border-color: var(--primary);
        }
        
        .feature-icon {
            width: 3.5rem;
            height: 3.5rem;
            background: rgba(79,70,229,0.1);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon i {
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        .feature-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }
        
        .feature-desc {
            color: var(--gray);
            line-height: 1.5;
        }
        
        /* Stats Section */
        .stats-section {
            background: var(--primary);
            border-radius: 2rem;
            padding: 3rem 2rem;
            margin: 4rem 0;
        }
        
        .stat-item {
            text-align: center;
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* How It Works */
        .step-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .step-number {
            width: 3rem;
            height: 3rem;
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        
        .step-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .step-desc {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 2rem;
            height: 100%;
        }
        
        .testimonial-avatar {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }
        
        .testimonial-name {
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .testimonial-role {
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        .testimonial-text {
            margin-top: 1rem;
            color: var(--gray);
            font-style: italic;
        }
        
        .rating i {
            color: #fbbf24;
            font-size: 0.9rem;
        }
        
        /* FAQ */
        .faq-item {
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 0;
        }
        
        .faq-question {
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-answer {
            padding-top: 0.5rem;
            color: var(--gray);
            display: none;
        }
        
        .faq-answer.show {
            display: block;
        }
        
        /* CTA */
        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 2rem;
            padding: 4rem 2rem;
            text-align: center;
            color: white;
        }
        
        .cta-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        
        .cta-button {
            background: white;
            color: var(--primary);
            padding: 0.75rem 2rem;
            border-radius: 2rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }
        
        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .social-icons a {
            display: inline-block;
            width: 2.2rem;
            height: 2.2rem;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 2.2rem;
            margin-right: 0.5rem;
            transition: all 0.2s;
        }
        
        .social-icons a:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-stats {
                flex-wrap: wrap;
                gap: 1rem;
            }
            .section-title {
                font-size: 1.8rem;
            }
            .hero-image {
                text-align: center;
                margin-top: 2rem;
            }
            .hero-image img {
                max-width: 70%;
                transform: translateX(0);
            }
            @keyframes floatImage {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-15px); }
                100% { transform: translateY(0px); }
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
    <img src="https://c.top4top.io/p_3749c8ad71.png" alt="Logo SISFO PKL" style="height: 32px; margin-right: 8px; vertical-align: middle;">
    SISFO PKL
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#how-it-works">Cara Kerja</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Testimoni</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                <li class="nav-item"><a class="btn btn-primary ms-2" href="{{ route('login') }}">Masuk</a></li>
                <li class="nav-item"><a class="btn btn-outline-primary ms-2" href="{{ route('register') }}">Daftar</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="hero-title">Kelola PKL <span>Lebih Mudah</span> & Profesional</h1>
                <p class="hero-subtitle">Platform terintegrasi untuk monitoring Praktek Kerja Lapangan. Pantau logbook, laporan, dan penilaian secara real-time.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2">Mulai Sekarang</a>
                    <a href="#features" class="btn btn-outline-primary px-4 py-2">Pelajari Lebih</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <h3>500+</h3>
                        <p>Mahasiswa</p>
                    </div>
                    <div class="hero-stat">
                        <h3>50+</h3>
                        <p>Dosen</p>
                    </div>
                    <div class="hero-stat">
                        <h3>100+</h3>
                        <p>Perusahaan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-image" data-aos="fade-left">
                <img src="https://c.top4top.io/p_3749c8ad71.png" alt="Hero Illustration">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Fitur Unggulan</h2>
        <p class="section-subtitle" data-aos="fade-up">Semua yang Anda butuhkan untuk monitoring PKL</p>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-book"></i></div>
                    <h3 class="feature-title">Logbook Digital</h3>
                    <p class="feature-desc">Catat kegiatan harian dengan mudah, lengkapi dokumentasi dan dapatkan approval real-time.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                    <h3 class="feature-title">Laporan Online</h3>
                    <p class="feature-desc">Upload laporan PKL, tracking revisi, dan review langsung oleh dosen pembimbing.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-star"></i></div>
                    <h3 class="feature-title">Penilaian Terpadu</h3>
                    <p class="feature-desc">Penilaian dari dosen dan PT dengan perhitungan otomatis, hasil langsung terlihat.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3 class="feature-title">Multi Role</h3>
                    <p class="feature-desc">Mendukung 4 role: Admin, Dosen, PT, dan Siswa dengan akses sesuai kebutuhan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-bell"></i></div>
                    <h3 class="feature-title">Notifikasi Real-time</h3>
                    <p class="feature-desc">Dapatkan notifikasi setiap ada logbook baru, review, atau perubahan status.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h3 class="feature-title">Rekap & Analisis</h3>
                    <p class="feature-desc">Lihat statistik dan rekap data PKL dalam bentuk grafik yang informatif.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="container">
    <div class="stats-section" data-aos="zoom-in">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-count="5000">0</div>
                    <div class="stat-label">Pengguna Aktif</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-count="10000">0</div>
                    <div class="stat-label">Logbook Tercatat</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-count="98">0</div>
                    <div class="stat-label">Kepuasan</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="stat-number" data-count="247">24/7</div>
                    <div class="stat-label">Dukungan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section id="how-it-works" class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Cara Kerja</h2>
        <p class="section-subtitle" data-aos="fade-up">Langkah mudah menggunakan SISFO PKL</p>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h4 class="step-title">Registrasi Akun</h4>
                    <p class="step-desc">Daftar sebagai mahasiswa, dosen, atau perusahaan sesuai peran Anda.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h4 class="step-title">Bergabung Kelompok</h4>
                    <p class="step-desc">Admin akan menempatkan Anda ke dalam kelompok PKL yang sesuai.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h4 class="step-title">Isi Logbook</h4>
                    <p class="step-desc">Catat kegiatan harian dan upload dokumentasi kegiatan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h4 class="step-title">Upload Laporan</h4>
                    <p class="step-desc">Unggah laporan PKL untuk direview oleh dosen.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="step-card">
                    <div class="step-number">5</div>
                    <h4 class="step-title">Review & Penilaian</h4>
                    <p class="step-desc">Dosen dan PT memberikan penilaian dan review.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                <div class="step-card">
                    <div class="step-number">6</div>
                    <h4 class="step-title">Lihat Hasil</h4>
                    <p class="step-desc">Mahasiswa bisa melihat nilai dan rekap akhir PKL.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Apa Kata Mereka?</h2>
        <p class="section-subtitle" data-aos="fade-up">Testimoni dari pengguna kami</p>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="testimonial-avatar">
                        <div>
                            <h5 class="testimonial-name">Dr. Ahmad Fauzi</h5>
                            <p class="testimonial-role">Dosen Pembimbing</p>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Sistem ini sangat membantu dalam memantau kemajuan PKL mahasiswa. Approval logbook dan laporan jadi lebih terstruktur."</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User" class="testimonial-avatar">
                        <div>
                            <h5 class="testimonial-name">Siti Nurhaliza</h5>
                            <p class="testimonial-role">Mahasiswa</p>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Mengisi logbook jadi lebih mudah dan rapi. Fitur notifikasi membantu saya tahu status review."</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="User" class="testimonial-avatar">
                        <div>
                            <h5 class="testimonial-name">Budi Santoso</h5>
                            <p class="testimonial-role">HRD PT Maju Jaya</p>
                        </div>
                    </div>
                    <div class="rating mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Memudahkan kami menilai kinerja mahasiswa magang. Rekap nilai dan laporan sangat lengkap."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Pertanyaan Umum</h2>
        <p class="section-subtitle" data-aos="fade-up">Yang sering ditanyakan pengguna</p>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-item" data-aos="fade-up">
                    <div class="faq-question">
                        <span>Apakah sistem ini gratis?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Ya, Tentu saja ini open source di github @muadzie.</div>
                </div>
                <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="faq-question">
                        <span>Bagaimana cara mendapatkan akun?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Anda bisa mendaftar langsung melalui halaman register. Admin akan memverifikasi dan mengaktifkan akun Anda.</div>
                </div>
                <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="faq-question">
                        <span>Apakah data aman?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Data dienkripsi dan disimpan di server dengan keamanan tinggi. Kami menjaga kerahasiaan data Anda.</div>
                </div>
                <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="faq-question">
                        <span>Bisa diakses dari HP?</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Tentu, platform kami responsif dan bisa diakses dari berbagai perangkat, termasuk smartphone.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="container my-5">
    <div class="cta-section" data-aos="zoom-in">
        <h2 class="cta-title">Siap Mengelola PKL Lebih Efisien?</h2>
        <p class="mb-4">Daftar sekarang dan rasakan kemudahan monitoring PKL.</p>
        <a href="{{ route('register') }}" class="cta-button">Daftar Sekarang <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Hubungi Kami</h2>
        <p class="section-subtitle" data-aos="fade-up">Ada pertanyaan? Tim kami siap membantu</p>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card text-center">
                    <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                    <h5>Alamat Kantor</h5>
                    <p class="text-muted">Mahasiswa Unsub</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card text-center">
                    <i class="fas fa-phone-alt fa-2x text-primary mb-3"></i>
                    <h5>Telepon</h5>
                    <p class="text-muted">(021) 1234-5678<br>0812-3456-7890</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card text-center">
                    <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                    <h5>Email</h5>
                    <p class="text-muted">info@sisfo-pkl.id<br>support@sisfo-pkl.id</p>
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
                <h5 class="text-white mb-3"><a class="navbar-brand" href="{{ route('home') }}">
    <img src="https://c.top4top.io/p_3749c8ad71.png" alt="Logo SISFO PKL" style="height: 32px; margin-right: 8px; vertical-align: middle;">
</a> SISFO PKL</h5>
                <p>Platform monitoring PKL terintegrasi untuk pendidikan vokasi dan magang.</p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="text-white mb-3">Tautan</h6>
                <ul class="list-unstyled">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#how-it-works">Cara Kerja</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="text-white mb-3">Sumber Daya</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Panduan Pengguna</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="text-white mb-3">Newsletter</h6>
                <p>Dapatkan update fitur terbaru.</p>
                <div class="input-group">
                    <input type="email" class="form-control bg-dark text-white border-secondary" placeholder="Email Anda">
                    <button class="btn btn-primary" type="button">Langganan</button>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center">
            <p class="mb-0">&copy; {{ date('Y') }} SISFO PKL. By Ilham Mu'adz Fakhrizi and Tim❤️.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Counter animation
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;
    const observerOptions = { threshold: 0.5, rootMargin: '0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const updateCount = () => {
                    const target = parseInt(counter.getAttribute('data-count'));
                    const count = parseInt(counter.innerText);
                    const increment = target / speed;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    counters.forEach(counter => observer.observe(counter));

    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            answer.classList.toggle('show');
            const icon = question.querySelector('i');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    });
</script>
</body>
</html>