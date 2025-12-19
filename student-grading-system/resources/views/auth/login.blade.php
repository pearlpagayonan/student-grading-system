<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GradeMaster</title>

<style>
        * { 
            font-family: 'Tahoma', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            display: flex;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            min-height: 600px;
        }
        
        /* Left Side - Brand/Info */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #008080 0%, #006666 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .brand-info {
            text-align: center;
        }
        
        .brand-logo {
            font-size: 48px;
            margin-bottom: 20px;
            color: #FFA500;
        }
        
        .brand-info h1 {
            font-size: 36px;
            margin-bottom: 15px;
            color: white;
        }
        
        .brand-info h1 span {
            color: #FFA500;
        }
        
        .brand-info p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .features {
            margin-top: 40px;
        }
        
        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            transition: transform 0.3s;
        }
        
        .feature:hover {
            transform: translateX(10px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .feature-icon {
            background: #FFA500;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
        }
        
        .feature-text h4 {
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .feature-text p {
            font-size: 13px;
            opacity: 0.8;
            margin: 0;
        }
        
        /* Right Side - Login Form */
        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header h2 {
            color: #008080;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #008080;
            font-weight: 600;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #008080;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 128, 128, 0.1);
        }
        
        .form-control::placeholder {
            color: #999;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #008080;
            cursor: pointer;
            font-size: 16px;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
            accent-color: #008080;
        }
        
        .remember-me label {
            color: #666;
            font-size: 14px;
            cursor: pointer;
        }
        
        .forgot-password a {
            color: #008080;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .forgot-password a:hover {
            color: #006666;
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: #FFA500;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-login:hover {
            background: #E69500;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: #FFEBEE;
            color: #C62828;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #C62828;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .error-message i {
            font-size: 18px;
        }
        
        .success-message {
            background: #E8F5E9;
            color: #2E7D32;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #2E7D32;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .success-message i {
            font-size: 18px;
        }
        
        .register-links {
            margin-top: 30px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }
        
        .register-links p {
            color: #666;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .register-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn-register {
            flex: 1;
            padding: 12px;
            background: #f8f9fa;
            color: #008080;
            border: 2px solid #008080;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background: #FFA500;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-register-teacher {
            border-color: #FFA500;
            color: #FFA500;
        }

        
        /* Responsive */
        @media (max-width: 900px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 500px;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .login-right {
                padding: 40px 30px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .login-left, .login-right {
                padding: 30px 20px;
            }
            
            .register-buttons {
                flex-direction: column;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-container {
            animation: fadeIn 0.6s ease-out;
        }
        
        /* Input focus animation */
        .form-control:focus {
            animation: inputFocus 0.3s ease-out;
        }
        
        @keyframes inputFocus {
            0% { transform: scale(1); }
            50% { transform: scale(1.01); }
            100% { transform: scale(1); }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side - Brand Info -->
        <div class="login-left">
            <div class="brand-info">
                <div class="brand-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Grade<span>Master</span></h1>
                <p>Your comprehensive solution for managing student grades and academic performance with precision and efficiency.</p>
            </div>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Real-time Analytics</h4>
                        <p>Track student performance with detailed statistics</p>
                    </div>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Student Management</h4>
                        <p>Comprehensive student profiles and grade tracking</p>
                    </div>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Secure & Reliable</h4>
                        <p>Your data is protected with enterprise-grade security</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your GradeMaster account</p>
            </div>
            
            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope" style="margin-right: 5px;"></i>
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                        class="form-control" required autofocus placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock" style="margin-right: 5px;"></i>
                        Password
                    </label>
                    <div class="password-wrapper">
                        <input id="password" type="password" name="password" 
                            class="form-control" required placeholder="Enter your password">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-key" style="margin-right: 5px;"></i>
                            Forgot Password?
                        </a>
                    </div>
                    @endif
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Log In
                </button>
            </form>
            
            <div class="register-links">
                <p>Don't have an account?</p>
                <div class="register-buttons">
                    <a href="{{ route('register.teacher') }}" class="btn-register btn-register-teacher">
                        <i class="fas fa-chalkboard-teacher" style="margin-right: 5px;"></i>
                        Register as Teacher
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            // Add loading state
            const submitBtn = document.querySelector('.btn-login');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing in...';
            submitBtn.disabled = true;
            
            // Re-enable after 5 seconds if still on page (fallback)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
            
            return true;
        });
        
        // Auto-focus email field on page load
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }
        });
        
        // Add animation to form elements
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach((control, index) => {
            control.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>
</html>