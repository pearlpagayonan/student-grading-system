<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grading System')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            color: #FFA500; 
            font-size: 24px;
        }
        
        .btn-orange { 
            background: #FFA500; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .btn-orange:hover {
            background: #e69500;
        }
        
        .table { 
            width: 100%; 
            background: white; 
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            margin-bottom: 20px;
        }
        
        .table th { 
            background: #008080; 
            color: white; 
            padding: 15px; 
            text-align: left; 
        }
        
        .table td { 
            padding: 15px; 
            border-bottom: 1px solid #eee; 
        }
        
        .table tr:hover { 
            background: #FFF4E0; 
        }
        
        .profile-pic { 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 2px solid #eee;
        }
        
        .badge { 
            padding: 5px 10px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold;
        }
        
        .badge-male { 
            background: #E3F2FD; 
            color: #1565C0; 
        }
        
        .badge-female { 
            background: #FCE4EC; 
            color: #C2185B; 
        }
        
        .badge-other { 
            background: #E8F5E9; 
            color: #2E7D32; 
        }
        
        .action-buttons button {
            border: none;
            padding: 6px 12px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
            transition: opacity 0.3s;
        }
        
        .action-buttons button:hover {
            opacity: 0.9;
        }
        
        .view-btn { background: #008080; color: white; }
        .edit-btn { background: #FFA500; color: white; }
        .delete-btn { background: #f44336; color: white; }
        
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 15px;
            margin: 0 3px;
            background: white;
            border-radius: 5px;
            text-decoration: none;
            color: #008080;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        .pagination .active {
            background: #008080;
            color: white;
            border-color: #008080;
        }
        
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
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>Grade<span>Master</span></h2>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a></li>
            
            <li><a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Manage Students</span>
            </a></li>
            
            <li><a href="{{ route('grades.manage') }}">
                <i class="fas fa-graduation-cap"></i> <span>Manage Grades</span>
            </a></li>
            
            <li><a href="{{ route('archives.index') }}">
                <i class="fas fa-archive"></i> <span>Archives</span>
            </a></li>
            
            <li><a href="{{ route('profile.edit') }}">
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
        
        <!-- DYNAMIC CONTENT AREA -->
        @yield('content')
        
    </div>
    
    <script>
        // Common scripts
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });

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
    
    @yield('scripts')
</body>
</html>