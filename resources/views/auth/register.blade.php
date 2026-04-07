<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SISFO PKL</title>
    
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
        
        /* Register Container */
        .register-container {
            max-width: 480px;
            width: 100%;
            z-index: 1;
            position: relative;
            margin: 40px auto;
        }
        
        /* Register Card */
        .register-card {
            background: var(--white);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.2);
        }
        
        /* Header */
        .register-header {
            background: var(--white);
            padding: 2rem 2rem 1rem;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .register-header .logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-header .logo img {
            width: 100%;
            height: auto;
        }
        
        .register-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .register-header p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        /* Body */
        .register-body {
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
        
        .form-control.is-invalid {
            border-color: #ef4444;
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
        
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }
        
        .strength-bar {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .strength-bar-fill {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background 0.3s ease;
        }
        
        .strength-text {
            font-size: 0.7rem;
            margin-top: 0.25rem;
            color: var(--gray);
        }
        
        /* Terms Checkbox */
        .terms-group {
            margin: 1.5rem 0;
        }
        
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .terms-checkbox input {
            width: 1rem;
            height: 1rem;
            margin-top: 0.2rem;
            accent-color: var(--primary);
            cursor: pointer;
        }
        
        .terms-text {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.4;
        }
        
        .terms-text a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .terms-text a:hover {
            text-decoration: underline;
        }
        
        /* Register Button */
        .btn-register {
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
        
        .btn-register:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(79,70,229,0.4);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .btn-register.loading {
            opacity: 0.8;
            pointer-events: none;
        }
        
        .btn-register.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Login Link */
        .login-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .login-section p {
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .login-link {
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
        
        .login-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79,70,229,0.2);
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .register-body {
                padding: 1.5rem;
            }
            .register-header {
                padding: 1.5rem;
            }
            .register-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-card" data-aos="fade-up">
        <!-- Header -->
        <div class="register-header">
            <div class="logo">
                <!-- Ganti dengan logo PNG jika ada -->
                <img src="https://c.top4top.io/p_3749c8ad71.png" alt="SISFO PKL Logo" style="width: 60px;">
            </div>
            <h2>Buat Akun Baru</h2>
            <p>Bergabung dengan SISFO PKL</p>
        </div>
        
        <!-- Body -->
        <div class="register-body">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-custom alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span><br>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name Field -->
                <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" 
                            placeholder="Masukkan nama lengkap"
                            required 
                            autofocus 
                            autocomplete="name"
                        >
                    </div>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                    <label for="email">Alamat Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            placeholder="contoh@email.com"
                            required 
                            autocomplete="username"
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Buat password"
                            required 
                            autocomplete="new-password"
                        >
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strengthBarFill"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Masukkan password</div>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-control" 
                            placeholder="Ulangi password"
                            required 
                            autocomplete="new-password"
                        >
                        <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                    </div>
                    <div class="error-message" id="passwordMatchError" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i> Password tidak cocok
                    </div>
                </div>

                <!-- Terms and Privacy Policy (Jetstream) -->
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="terms-group">
                        <label class="terms-checkbox">
                            <input type="checkbox" name="terms" id="terms" required>
                            <span class="terms-text">
                                Saya setuju dengan 
                                <a href="{{ route('terms.show') }}" target="_blank">Syarat & Ketentuan</a> 
                                dan 
                                <a href="{{ route('policy.show') }}" target="_blank">Kebijakan Privasi</a>
                            </span>
                        </label>
                    </div>
                @endif

                <!-- Register Button -->
                <button type="submit" class="btn-register" id="registerButton">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-section">
                <p>Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="login-link">
                    <i class="fas fa-sign-in-alt"></i> Masuk
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
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Password Strength Checker
    const strengthBarFill = document.getElementById('strengthBarFill');
    const strengthText = document.getElementById('strengthText');

    password.addEventListener('input', function() {
        const val = this.value;
        let strength = 0;
        
        if (val.length >= 8) strength += 25;
        if (val.match(/[a-z]+/)) strength += 25;
        if (val.match(/[A-Z]+/)) strength += 25;
        if (val.match(/[0-9]+/)) strength += 25;
        if (val.match(/[$@#&!]+/)) strength += 25;
        
        strength = Math.min(strength, 100);
        
        strengthBarFill.style.width = strength + '%';
        
        if (strength < 25) {
            strengthBarFill.style.backgroundColor = '#ef4444';
            strengthText.textContent = 'Password terlalu lemah';
            strengthText.style.color = '#ef4444';
        } else if (strength < 50) {
            strengthBarFill.style.backgroundColor = '#f59e0b';
            strengthText.textContent = 'Password lemah';
            strengthText.style.color = '#f59e0b';
        } else if (strength < 75) {
            strengthBarFill.style.backgroundColor = '#06b6d4';
            strengthText.textContent = 'Password sedang';
            strengthText.style.color = '#06b6d4';
        } else {
            strengthBarFill.style.backgroundColor = '#10b981';
            strengthText.textContent = 'Password kuat';
            strengthText.style.color = '#10b981';
        }
    });

    // Password Match Check
    const passwordMatchError = document.getElementById('passwordMatchError');

    function checkPasswordMatch() {
        if (confirmPassword.value && password.value !== confirmPassword.value) {
            passwordMatchError.style.display = 'flex';
            confirmPassword.classList.add('is-invalid');
        } else {
            passwordMatchError.style.display = 'none';
            confirmPassword.classList.remove('is-invalid');
        }
    }

    password.addEventListener('keyup', checkPasswordMatch);
    confirmPassword.addEventListener('keyup', checkPasswordMatch);

    // Loading State on Form Submit
    const registerForm = document.getElementById('registerForm');
    const registerButton = document.getElementById('registerButton');

    registerForm.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            passwordMatchError.style.display = 'flex';
            confirmPassword.classList.add('is-invalid');
            return;
        }
        
        registerButton.classList.add('loading');
        registerButton.innerHTML = '<i class="fas fa-spinner"></i><span>Memproses...</span>';
    });
</script>
</body>
</html>