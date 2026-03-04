<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Monitoring PKL</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            /* HAPUS overflow: hidden - ini yang menyebabkan tidak bisa scroll */
            /* overflow: hidden; */ 
        }
        
        /* Background Shapes */
        .shape {
            position: fixed; /* Ubah dari absolute ke fixed */
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none; /* Agar tidak mengganggu klik */
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            bottom: 50px;
            left: 50px;
            background: rgba(255, 215, 0, 0.1);
        }
        
        /* Login Container */
        .login-container {
            max-width: 420px;
            width: 100%;
            z-index: 1;
            position: relative;
            margin: 40px auto; /* Tambah margin untuk ruang scroll */
        }
        
        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Header */
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .login-header .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .login-header .logo i {
            font-size: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .login-header h2 {
            color: white;
            font-weight: 600;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        
        /* Body */
        .login-body {
            padding: 40px 30px;
        }
        
        /* Alert Messages */
        .alert-custom {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideDown 0.4s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-custom i {
            font-size: 20px;
            margin-right: 10px;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border-left: 4px solid #28a745;
            color: #28a745;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left: 4px solid #dc3545;
            color: #dc3545;
        }
        
        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #ffc107;
            color: #ffc107;
        }
        
        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            color: #999;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .form-control:focus + .input-icon {
            color: #667eea;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            color: #999;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        /* Remember Me & Forgot Password */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }
        
        .remember-me span {
            color: #666;
            font-size: 0.9rem;
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:hover:before {
            width: 300px;
            height: 300px;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }
        
        .btn-login:hover i {
            transform: translateX(5px);
        }
        
        /* Register Link */
        .register-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px dashed #e1e5e9;
        }
        
        .register-section p {
            color: #666;
            margin-bottom: 10px;
        }
        
        .register-link {
            display: inline-block;
            padding: 10px 30px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .register-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
        }
        
        .register-link i {
            margin-right: 5px;
        }
        
        /* Loading State */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        
        .btn-login.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 30px 20px;
            }
            
            .form-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .login-container {
                margin: 20px auto;
            }
        }
        
        /* Small height screens */
        @media (max-height: 700px) {
            .login-header {
                padding: 25px 20px;
            }
            
            .login-header .logo {
                width: 60px;
                height: 60px;
                margin-bottom: 10px;
            }
            
            .login-header .logo i {
                font-size: 30px;
            }
            
            .login-body {
                padding: 25px 20px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>

<!-- Background Shapes -->
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>

<!-- Login Container -->
<div class="login-container">
    <div class="login-card" data-aos="fade-up">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h2>Selamat Datang Kembali!</h2>
            <p>Silakan login ke akun Anda</p>
        </div>
        
        <!-- Body -->
        <div class="login-body">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-custom alert-danger" data-aos="fade-in">
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
                <div class="alert-custom alert-success" data-aos="fade-in">
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
                            placeholder="Masukkan email Anda"
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
                            placeholder="Masukkan password Anda"
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
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </button>
            </form>

            <!-- Register Section -->
            <div class="register-section" data-aos="fade-up" data-aos-delay="500">
                <p>Belum punya akun?</p>
                <a href="{{ route('register') }}" class="register-link">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true
    });

    // Password Toggle
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle icon
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

    // Floating Label Effect
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('.input-icon').style.color = '#667eea';
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.querySelector('.input-icon').style.color = '#999';
            }
        });
    });
    
    // Smooth scroll for small screens (opsional)
    if (window.innerHeight < 700) {
        document.body.style.alignItems = 'flex-start';
    }
</script>

</body>
</html>