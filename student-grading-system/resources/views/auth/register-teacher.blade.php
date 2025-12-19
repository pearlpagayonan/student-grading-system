<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration - GradeMaster</title>
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
        
        .register-wrapper {
            width: 100%;
            max-width: 1200px;
            display: flex;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            min-height: 600px;
        }
        
        /* Left Side - Teacher Info */
        .register-left {
            flex: 1;
            background: linear-gradient(135deg, #008080 0%, #006666 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .teacher-info {
            text-align: center;
        }
        
        .teacher-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #FFA500;
        }
        
        .teacher-info h1 {
            font-size: 36px;
            margin-bottom: 15px;
            color: white;
        }
        
        .teacher-info h1 span {
            color: #FFA500;
        }
        
        .teacher-info p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .teacher-badge {
            display: inline-block;
            background: #FFA500;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }
        
        .benefits {
            margin-top: 40px;
        }
        
        .benefit {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            transition: transform 0.3s;
        }
        
        .benefit:hover {
            transform: translateX(10px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .benefit-icon {
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
        
        .benefit-text h4 {
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .benefit-text p {
            font-size: 13px;
            opacity: 0.8;
            margin: 0;
        }
        
        /* Right Side - Registration Form */
        .register-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .register-header h2 {
            color: #008080;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .register-header p {
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
            display: flex;
            align-items: center;
        }
        
        .form-group label i {
            margin-right: 8px;
            width: 20px;
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
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
            margin-bottom: 20px;
        }
        
        .strength-meter {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background 0.3s;
            border-radius: 2px;
        }
        
        .strength-weak { width: 33%; background: #f44336; }
        .strength-medium { width: 66%; background: #FFA500; }
        .strength-strong { width: 100%; background: #4CAF50; }
        
        .strength-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            text-align: right;
        }
        
        .btn-register {
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
            margin-top: 10px;
        }
        
        .btn-register:hover {
            background: #E69500;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }
        
        .btn-register:active {
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
        
        .login-link {
            margin-top: 30px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }
        
        .login-link p {
            color: #666;
            font-size: 14px;
        }
        
        .login-link a {
            color: #008080;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .login-link a:hover {
            color: #006666;
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 900px) {
            .register-wrapper {
                flex-direction: column;
                max-width: 500px;
            }
            
            .register-left {
                padding: 40px 30px;
            }
            
            .register-right {
                padding: 40px 30px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .register-left, .register-right {
                padding: 30px 20px;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .register-container {
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
        
        /* Teacher ID Preview */
        .id-preview {
            font-size: 12px;
            color: #008080;
            margin-top: 5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .terms-agreement {
            display: flex;
            align-items: flex-start;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .terms-agreement input {
            margin-top: 3px;
            margin-right: 10px;
            accent-color: #008080;
        }
        
        .terms-agreement label {
            color: #666;
            font-size: 13px;
            font-weight: normal;
            line-height: 1.4;
        }
        
        .terms-agreement a {
            color: #008080;
            text-decoration: none;
        }
        
        .terms-agreement a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="register-wrapper">
        <!-- Left Side - Teacher Benefits -->
        <div class="register-left">
            <div class="teacher-info">
                <div class="teacher-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="teacher-badge">TEACHER REGISTRATION</div>
                <h1>Join <span>GradeMaster</span></h1>
                <p>Create your teacher account to access powerful grading tools and student management features designed for educators.</p>
            </div>
            
            <div class="benefits">
                <div class="benefit">
                    <div class="benefit-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="benefit-text">
                        <h4>Grade Management</h4>
                        <p>Easily manage and track student grades</p>
                    </div>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="benefit-text">
                        <h4>Analytics Dashboard</h4>
                        <p>Visualize student performance with detailed reports</p>
                    </div>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="benefit-text">
                        <h4>Student Management</h4>
                        <p>Manage multiple classes and student profiles</p>
                    </div>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <div class="benefit-text">
                        <h4>Export Features</h4>
                        <p>Export grades and reports in multiple formats</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="register-right">
            <div class="register-header">
                <h2>Create Teacher Account</h2>
                <p>Fill in your details to get started</p>
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
            
            <form method="POST" action="{{ route('register.teacher') }}" id="teacherRegisterForm">
                @csrf
                
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" 
                        class="form-control" required autofocus placeholder="Enter your full name">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" 
                            class="form-control" required placeholder="teacher@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="teacher_id">
                            <i class="fas fa-id-card"></i>
                            Teacher ID
                        </label>
                        <input id="teacher_id" type="text" name="teacher_id" value="{{ old('teacher_id') }}" 
                            class="form-control" required placeholder="T-2024-001"
                            oninput="updateIdPreview(this.value)">
                        <div class="id-preview" id="idPreview">
                            <i class="fas fa-info-circle"></i>
                            <span>Your unique teacher identifier</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-wrapper">
                            <input id="password" type="password" name="password" 
                                class="form-control" required placeholder="Create a strong password"
                                oninput="checkPasswordStrength(this.value)">
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="strength-meter">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Password strength</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">
                            <i class="fas fa-lock"></i>
                            Confirm Password
                        </label>
                        <div class="password-wrapper">
                            <input id="password_confirmation" type="password" name="password_confirmation" 
                                class="form-control" required placeholder="Confirm your password">
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" style="font-size: 12px; margin-top: 5px;"></div>
                    </div>
                </div>
                
                <div class="terms-agreement">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="#" onclick="return false;">Terms of Service</a> and 
                        <a href="#" onclick="return false;">Privacy Policy</a>. I understand that this account 
                        is for educational purposes only.
                    </label>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    Create Teacher Account
                </button>
            </form>
            
            <div class="login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleButton = passwordInput.parentNode.querySelector('.toggle-password i');
            
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
        
        // Check password strength
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            // Reset
            strengthBar.className = 'strength-bar';
            
            let strength = 0;
            let text = 'Password strength';
            
            // Check length
            if (password.length >= 8) strength++;
            
            // Check for lowercase
            if (/[a-z]/.test(password)) strength++;
            
            // Check for uppercase
            if (/[A-Z]/.test(password)) strength++;
            
            // Check for numbers
            if (/[0-9]/.test(password)) strength++;
            
            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Update UI
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthText.textContent = 'Password strength';
            } else if (strength <= 2) {
                strengthBar.className = 'strength-bar strength-weak';
                strengthText.textContent = 'Weak password';
            } else if (strength <= 4) {
                strengthBar.className = 'strength-bar strength-medium';
                strengthText.textContent = 'Medium strength';
            } else {
                strengthBar.className = 'strength-bar strength-strong';
                strengthText.textContent = 'Strong password';
            }
            
            // Check password match
            checkPasswordMatch();
        }
        
        // Check if passwords match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword.length === 0) {
                matchDiv.textContent = '';
                matchDiv.style.color = '';
            } else if (password === confirmPassword) {
                matchDiv.innerHTML = '<i class="fas fa-check-circle" style="color: #4CAF50; margin-right: 5px;"></i> Passwords match';
                matchDiv.style.color = '#4CAF50';
            } else {
                matchDiv.innerHTML = '<i class="fas fa-times-circle" style="color: #f44336; margin-right: 5px;"></i> Passwords do not match';
                matchDiv.style.color = '#f44336';
            }
        }
        
        // Update ID preview
        function updateIdPreview(value) {
            const preview = document.getElementById('idPreview');
            if (value.trim()) {
                preview.innerHTML = `<i class="fas fa-id-badge"></i> Your ID: <strong>${value}</strong>`;
            } else {
                preview.innerHTML = '<i class="fas fa-info-circle"></i> Your unique teacher identifier';
            }
        }
        
        // Form validation
        document.getElementById('teacherRegisterForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const teacherId = document.getElementById('teacher_id').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            // Basic validation
            if (!name || !email || !teacherId || !password || !confirmPassword) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
            
            if (!terms) {
                e.preventDefault();
                alert('You must agree to the Terms of Service and Privacy Policy.');
                return false;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please check and try again.');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return false;
            }
            
            // Add loading state
            const submitBtn = document.querySelector('.btn-register');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
            submitBtn.disabled = true;
            
            // Re-enable after 5 seconds if still on page (fallback)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
            
            return true;
        });
        
        // Real-time password confirmation check
        document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
        
        // Auto-focus name field on page load
        document.addEventListener('DOMContentLoaded', function() {
            const nameField = document.getElementById('name');
            if (nameField && !nameField.value) {
                nameField.focus();
            }
            
            // Show initial ID preview if there's existing value
            const teacherIdField = document.getElementById('teacher_id');
            if (teacherIdField.value) {
                updateIdPreview(teacherIdField.value);
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