<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Grading System</title>
    <style>
        * { 
            font-family: 'Tahoma', sans-serif; 
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            display: flex;
            min-height: 100vh;
            background: #f5f5f5;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: #008080;
            color: white;
            padding: 20px 0;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }
        
        .logo h2 {
            color: white;
            font-size: 22px;
        }
        
        .logo span {
            color: #FFA500;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 20px;
        }
        
        .nav-menu li {
            margin-bottom: 10px;
        }
        
        .nav-menu a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .nav-menu a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .nav-menu a.active {
            background: #FFA500;
        }
        
        .nav-menu i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .nav-menu .logout {
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
        }
        
        .nav-menu .logout a {
            color: #FFB6C1;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 { 
            color: #008080; 
            font-size: 24px;
        }
        
        .btn-teal { 
            background: #008080; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .btn-teal:hover {
            background: #006666;
        }
        
        /* Profile Container */
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .profile-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .profile-card h2 {
            color: #008080;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            font-size: 20px;
        }
        
        .profile-card h2 i {
            margin-right: 10px;
            color: #FFA500;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #008080;
            box-shadow: 0 0 0 2px rgba(0, 128, 128, 0.1);
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-col {
            flex: 1;
        }
        
        /* Profile Picture */
        .profile-picture-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #008080;
            margin-bottom: 15px;
        }
        
        .profile-picture-upload {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        /* Buttons */
        .btn-primary {
            background: #008080;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }
        
        .btn-primary:hover {
            background: #006666;
        }
        
        .btn-danger {
            background: #f44336;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }
        
        .btn-danger:hover {
            background: #d32f2f;
        }
        
        .btn-warning {
            background: #FFA500;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }
        
        .btn-warning:hover {
            background: #e69500;
        }
        
        /* User Info */
        .user-info {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #008080;
        }
        
        .welcome-text {
            font-size: 14px;
            color: #666;
        }
        
        .welcome-text strong {
            color: #008080;
        }
        
        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
            border-left: 4px solid #4CAF50;
        }
        
        .alert-error {
            background: #FFEBEE;
            color: #C62828;
            border-left: 4px solid #f44336;
        }
        
        .alert-warning {
            background: #FFF3E0;
            color: #EF6C00;
            border-left: 4px solid #FF9800;
        }
        
        /* Password Strength */
        .password-strength {
            margin-top: 10px;
            height: 5px;
            border-radius: 3px;
            background: #eee;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar .logo h2,
            .sidebar .nav-menu span {
                display: none;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .nav-menu a {
                justify-content: center;
                padding: 15px;
            }
            
            .nav-menu i {
                margin-right: 0;
                font-size: 20px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .profile-picture {
                width: 120px;
                height: 120px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>Grade<span>Master</span></h2>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a></li>
            
            <li><a href="{{ route('students.index') }}">
                <i class="fas fa-users"></i> <span>Manage Students</span>
            </a></li>
            
            <li><a href="{{ route('grades.manage') }}">
                <i class="fas fa-graduation-cap"></i> <span>Manage Grades</span>
            </a></li>
            
            <li><a href="{{ route('archives.index') }}">
                <i class="fas fa-archive"></i> <span>Archives</span>
            </a></li>
            
            <li><a href="{{ route('profile.edit') }}" class="active">
                <i class="fas fa-user-cog"></i> <span>Profile Settings</span>
            </a></li>
            
            <li class="logout">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- User Info Bar -->
        <div class="user-info">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}" 
                 alt="{{ Auth::user()->name }}">
            <div>
                <div class="welcome-text">Welcome, <strong>{{ Auth::user()->name }}</strong>!</div>
                <div style="font-size: 12px; color: #888;">{{ date('F d, Y - h:i A') }}</div>
            </div>
        </div>
        
        <!-- Page Header -->
        <div class="header">
            <h1><i class="fas fa-user-cog"></i> Profile Settings</h1>
            <a href="{{ route('dashboard') }}" class="btn-teal">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <!-- Display Success/Error Messages -->
        @if(session('status'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> Please fix the following errors:
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="profile-container">
            <!-- Profile Information Card -->
            <div class="profile-card">
                <h2><i class="fas fa-user-edit"></i> Update Profile Information</h2>
                
                <div class="profile-picture-section">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="profile-picture"
                         id="profile-preview">
                    
                    <div class="profile-picture-upload">
                        <input type="file" id="profile-picture" accept="image/*" style="display: none;">
                        <button type="button" class="btn-warning" onclick="document.getElementById('profile-picture').click()">
                            <i class="fas fa-camera"></i> Change Photo
                        </button>
                        <span style="color: #666; font-size: 14px;">Max 2MB (JPG, PNG)</span>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;">
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_number"><i class="fas fa-phone"></i> Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" 
                               value="{{ old('contact_number', Auth::user()->contact_number) }}">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->isTeacher() ? 'Teacher' : (Auth::user()->isStudent() ? 'Student' : 'Admin') }}" disabled>
                            </div>
                        </div>
                        
                        <div class="form-col">
                            <div class="form-group">
                                <label>Account Created</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->created_at->format('F d, Y') }}" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Profile Changes
                    </button>
                </form>
            </div>
            
            <!-- Update Password Card -->
            <div class="profile-card">
                <h2><i class="fas fa-key"></i> Update Password</h2>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="current_password"><i class="fas fa-lock"></i> Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> New Password</label>
                        <input type="password" id="password" name="password" class="form-control" required 
                               onkeyup="checkPasswordStrength(this.value)">
                        <div class="password-strength">
                            <div class="password-strength-bar" id="password-strength-bar"></div>
                        </div>
                        <small style="color: #666;">Minimum 8 characters with letters and numbers</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-sync-alt"></i> Update Password
                    </button>
                </form>
            </div>
            
            <!-- Delete Account Card -->
            <div class="profile-card">
                <h2><i class="fas fa-exclamation-triangle"></i> Delete Account</h2>
                <p style="color: #666; margin-bottom: 20px;">
                    <i class="fas fa-info-circle"></i> Once your account is deleted, all of its resources and data will be permanently deleted. 
                    Please be certain before proceeding.
                </p>
                
                <button type="button" class="btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete Account
                </button>
                
                <!-- Hidden Delete Form -->
                <form method="POST" action="{{ route('profile.destroy') }}" id="delete-form" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" id="confirm_password" placeholder="Enter your password to confirm" required>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Highlight active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Profile picture preview
            const profilePicInput = document.getElementById('profile-picture');
            const profilePreview = document.getElementById('profile-preview');
            
            if (profilePicInput) {
                profilePicInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                        
                        // Also update the hidden form input
                        document.getElementById('profile_picture').files = this.files;
                    }
                });
            }
        });
        
        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('password-strength-bar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.background = '#f44336';
            } else if (strength < 75) {
                strengthBar.style.background = '#FF9800';
            } else {
                strengthBar.style.background = '#4CAF50';
            }
        }
        
        // Account deletion confirmation
        function confirmDelete() {
            const password = prompt('⚠️ ACCOUNT DELETION CONFIRMATION\n\nPlease enter your password to confirm account deletion:');
            
            if (password) {
                document.getElementById('confirm_password').value = password;
                
                if (confirm('⚠️ FINAL WARNING\n\nThis action cannot be undone. All your data will be permanently deleted.\n\nAre you absolutely sure?')) {
                    document.getElementById('delete-form').submit();
                }
            }
        }

        // Highlight active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Auto-refresh time every minute
            function updateTime() {
                const now = new Date();
                const options = { 
                    month: 'long', 
                    day: 'numeric', 
                    year: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true 
                };
                const timeElements = document.querySelectorAll('.welcome-text + div');
                if (timeElements.length > 0) {
                    timeElements[0].textContent = now.toLocaleDateString('en-US', options);
                }
            }
            
            // Update time initially and every minute
            updateTime();
            setInterval(updateTime, 60000);
            
            console.log('Dashboard loaded successfully!');
        });
    </script>
</body>
</html>