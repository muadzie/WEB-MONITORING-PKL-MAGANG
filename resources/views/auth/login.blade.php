<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SISFO PKL</title>
    
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
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        /* Login Container */
        .login-container {
            max-width: 440px;
            width: 100%;
            z-index: 1;
            position: relative;
            margin: 40px auto;
        }
        
        /* Login Card */
        .login-card {
            background: var(--white);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.2);
        }
        
        /* Header */
        .login-header {
            background: var(--white);
            padding: 2rem 2rem 1rem;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .login-header .logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-header .logo img {
            width: 100%;
            height: auto;
        }
        
        .login-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        /* Body */
        .login-body {
            padding: 2rem;
        }
        
        /* Alert Messages */
        .alert-custom {
            border-radius: 1rem;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }
        
        .alert-success {
            background: #ecfdf5;
            border-left: 4px solid #10b981;
            color: #065f46;
        }
        
        .alert-danger {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }
        
        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--gray);
            z-index: 2;
            font-size: 1rem;
            pointer-events: none;
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: var(--white);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
            outline: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            color: var(--gray);
            cursor: pointer;
            z-index: 2;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        /* Form Footer */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .remember-me input {
            width: 1rem;
            height: 1rem;
            accent-color: var(--primary);
            cursor: pointer;
        }
        
        .remember-me span {
            color: var(--gray);
        }
        
        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: var(--primary);
            border: none;
            border-radius: 1rem;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(79,70,229,0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login.loading {
            opacity: 0.8;
            pointer-events: none;
        }
        
        .btn-login.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Register Link */
        .register-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .register-section p {
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .register-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .register-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79,70,229,0.2);
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 1.5rem;
            }
            .login-header {
                padding: 1.5rem;
            }
            .login-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card" data-aos="fade-up">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <!-- Ganti dengan logo PNG jika ada -->
                <img src="https://c.top4top.io/p_3749c8ad71.png" alt="SISFO PKL Logo" style="width: 60px;">
            </div>
            <h2>Selamat Datang Kembali</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>
        
        <!-- Body -->
        <div class="login-body">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-custom alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Status Message -->
            @session('status')
                <div class="alert-custom alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $value }}</span>
                </div>
            @endsession

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Field -->
                <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                    <label for="email">Alamat Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            value="{{ old('email') }}" 
                            placeholder="contoh@email.com"
                            required 
                            autofocus 
                            autocomplete="username"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Masukkan password"
                            required 
                            autocomplete="current-password"
                        >
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-footer" data-aos="fade-up" data-aos-delay="300">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember_me">
                        <span>Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login" id="loginButton" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Masuk</span>
                </button>
            </form>

            <!-- Register Section -->
            <div class="register-section" data-aos="fade-up" data-aos-delay="500">
                <p>Belum punya akun?</p>
                <a href="{{ route('register') }}" class="register-link">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

    // Password Toggle
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Loading State on Form Submit
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');

    loginForm.addEventListener('submit', function() {
        loginButton.classList.add('loading');
        loginButton.innerHTML = '<i class="fas fa-spinner"></i><span>Loading...</span>';
    });
</script>

</body>
</html>