<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Sistem Monitoring PKL</title>
    
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
            overflow-x: hidden;
        }
        
        /* Background Shapes */
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
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
        
        .shape-4 {
            width: 100px;
            height: 100px;
            top: 50%;
            right: 10%;
            background: rgba(255, 255, 255, 0.05);
        }
        
        /* Register Container */
        .register-container {
            max-width: 500px;
            width: 100%;
            z-index: 1;
            position: relative;
        }
        
        /* Register Card */
        .register-card {
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
        .register-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 30px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .register-header:before {
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
        
        .register-header .logo {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .register-header .logo i {
            font-size: 35px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .register-header h2 {
            color: white;
            font-weight: 600;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }
        
        .register-header p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        
        /* Body */
        .register-body {
            padding: 35px 30px;
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
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left: 4px solid #dc3545;
            color: #dc3545;
        }
        
        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
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
            padding: 12px 15px 12px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1);
            outline: none;
        }
        
        .form-control:focus + .input-icon {
            color: #28a745;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            color: #999;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #28a745;
        }
        
        /* Error Message */
        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 5px;
            font-size: 0.8rem;
        }
        
        /* Terms Checkbox */
        .terms-group {
            margin: 25px 0;
        }
        
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
        }
        
        .terms-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #28a745;
        }
        
        .terms-text {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .terms-text a {
            color: #28a745;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .terms-text a:hover {
            color: #20c997;
            text-decoration: underline;
        }
        
        /* Register Button */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        
        .btn-register:before {
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
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
        }
        
        .btn-register:hover:before {
            width: 300px;
            height: 300px;
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .btn-register i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }
        
        .btn-register:hover i {
            transform: translateX(5px);
        }
        
        /* Login Link */
        .login-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed #e1e5e9;
        }
        
        .login-section p {
            color: #666;
            margin-bottom: 10px;
        }
        
        .login-link {
            display: inline-block;
            padding: 10px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .login-link i {
            margin-right: 5px;
        }
        
        /* Password Strength */
        .password-strength {
            margin-top: 8px;
        }
        
        .strength-bar {
            height: 4px;
            background: #e1e5e9;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .strength-bar-fill {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .strength-text {
            font-size: 0.8rem;
            margin-top: 5px;
            color: #666;
        }
        
        /* Loading State */
        .btn-register.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        
        .btn-register.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Role Selection (Optional - jika ingin menambah field role) */
        .role-selection {
            margin-bottom: 20px;
        }
        
        .role-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
        }
        
        .role-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .role-option {
            flex: 1;
            min-width: 100px;
        }
        
        .role-option input[type="radio"] {
            display: none;
        }
        
        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px 10px;
            background: #f8f9fa;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .role-option input[type="radio"]:checked + label {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
        }
        
        .role-option label i {
            font-size: 24px;
            margin-bottom: 8px;
            color: #666;
        }
        
        .role-option input[type="radio"]:checked + label i {
            color: #28a745;
        }
        
        .role-option label span {
            font-size: 0.9rem;
            font-weight: 500;
            color: #666;
        }
        
        .role-option input[type="radio"]:checked + label span {
            color: #28a745;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .register-body {
                padding: 25px 20px;
            }
            
            .role-options {
                flex-direction: column;
            }
            
            .role-option {
                min-width: auto;
            }
        }
    </style>
</head>
<body>

<!-- Background Shapes -->
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>
<div class="shape shape-4"></div>

<!-- Register Container -->
<div class="register-container">
    <div class="register-card" data-aos="fade-up">
        <!-- Header -->
        <div class="register-header">
            <div class="logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Buat Akun Baru</h2>
            <p>Bergabung dengan Sistem Monitoring PKL</p>
        </div>
        
        <!-- Body -->
        <div class="register-body">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-custom alert-danger" data-aos="fade-in">
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
                            placeholder="Masukkan nama lengkap Anda"
                            required 
                            autofocus 
                            autocomplete="name"
                        >
                    </div>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
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
                            placeholder="Masukkan email Anda"
                            required 
                            autocomplete="username"
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Optional: Role Selection (uncomment jika ingin menambah field role) -->
                <!-- 
                <div class="role-selection" data-aos="fade-up" data-aos-delay="250">
                    <div class="role-label">Daftar sebagai</div>
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" name="role" id="role_siswa" value="siswa" checked>
                            <label for="role_siswa">
                                <i class="fas fa-user-graduate"></i>
                                <span>Siswa</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" id="role_dosen" value="dosen">
                            <label for="role_dosen">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Dosen</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" id="role_pt" value="pt">
                            <label for="role_pt">
                                <i class="fas fa-building"></i>
                                <span>PT</span>
                            </label>
                        </div>
                    </div>
                </div>
                -->

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
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength" id="passwordStrength">
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
                        <i class="fas fa-exclamation-circle"></i>
                        Password tidak cocok
                    </div>
                </div>

                <!-- Terms and Privacy Policy -->
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="terms-group" data-aos="fade-up" data-aos-delay="500">
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
                <button type="submit" class="btn-register" id="registerButton" data-aos="fade-up" data-aos-delay="600">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-section" data-aos="fade-up" data-aos-delay="700">
                <p>Sudah punya akun?</p>
                <a href="{{ route('login') }}" class="login-link">
                    <i class="fas fa-sign-in-alt"></i>
                    Login di sini
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
        
        // Cap at 100
        strength = Math.min(strength, 100);
        
        // Update bar
        strengthBarFill.style.width = strength + '%';
        
        // Update color and text
        if (strength < 25) {
            strengthBarFill.style.backgroundColor = '#dc3545';
            strengthText.textContent = 'Password terlalu lemah';
            strengthText.style.color = '#dc3545';
        } else if (strength < 50) {
            strengthBarFill.style.backgroundColor = '#ffc107';
            strengthText.textContent = 'Password lemah';
            strengthText.style.color = '#ffc107';
        } else if (strength < 75) {
            strengthBarFill.style.backgroundColor = '#17a2b8';
            strengthText.textContent = 'Password sedang';
            strengthText.style.color = '#17a2b8';
        } else {
            strengthBarFill.style.backgroundColor = '#28a745';
            strengthText.textContent = 'Password kuat';
            strengthText.style.color = '#28a745';
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
        // Check if passwords match
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            passwordMatchError.style.display = 'flex';
            confirmPassword.classList.add('is-invalid');
            return;
        }
        
        registerButton.classList.add('loading');
        registerButton.innerHTML = '<i class="fas fa-spinner"></i><span>Memproses...</span>';
    });

    // Floating Label Effect
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.querySelector('.input-icon').style.color = '#28a745';
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.querySelector('.input-icon').style.color = '#999';
            }
        });
    });

    // Terms Checkbox Effect
    const termsCheckbox = document.getElementById('terms');
    if (termsCheckbox) {
        termsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                this.parentElement.style.color = '#28a745';
            } else {
                this.parentElement.style.color = '';
            }
        });
    }
</script>

</body>
</html>