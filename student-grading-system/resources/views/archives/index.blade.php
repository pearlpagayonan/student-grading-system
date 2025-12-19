<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Students - Grading System</title>
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
        
        /* ========== SIDEBAR ========== */
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
            letter-spacing: 1px;
        }
        
        .logo span {
            color: #FFA500;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 20px;
        }
        
        .nav-menu li {
            margin-bottom: 8px;
        }
        
        .nav-menu a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 6px;
            transition: all 0.3s;
            font-size: 14px;
        }
        

        
        .nav-menu a.active {
            background: #FFA500;
            font-weight: bold;
        }
        
        .nav-menu i {
            margin-right: 12px;
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        
        .nav-menu .logout {
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
        }
        
        .nav-menu .logout a {
            color: #FFB6C1;
        }
        
        .nav-menu .logout a:hover {
            background: rgba(255,182,193,0.1);
        }
        
        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 25px;
        }
        
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
            background: white;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        h1 { 
            color: #008080; 
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* ========== IMPROVED BUTTONS ========== */
        /* "Back to Students" Button - THICKER */
        .btn-back {
            background: #008080; 
            color: white; 
            padding: 10px 18px; /* THICKER PADDING */
            border: none; 
            border-radius: 6px; 
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            cursor: pointer;
            height: 40px; /* THICKER */
            box-shadow: 0 2px 4px rgba(0,128,128,0.2);
            border: 1px solid #006666;
        }
        
        .btn-back:hover {
            background: #006666;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,128,128,0.3);
        }
        
        .btn-back i {
            font-size: 14px !important; /* SMALLER ICON */
        }
        
        .btn-action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        /* Empty State Button */
        .btn-empty-state {
            background: #008080; 
            color: white; 
            padding: 10px 18px; 
            border: none; 
            border-radius: 6px; 
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            cursor: pointer;
            height: 40px;
            box-shadow: 0 2px 4px rgba(0,128,128,0.2);
            border: 1px solid #006666;
        }
        
        .btn-empty-state:hover {
            background: #006666;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,128,128,0.3);
        }
        
        .btn-empty-state i {
            font-size: 14px !important;
        }
        
        /* TABLE ACTION BUTTONS - SMALLER ICONS */
        .btn-orange { 
            background: #FFA500; 
            color: white; 
            padding: 7px 14px; 
            border: none; 
            border-radius: 5px; 
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            cursor: pointer;
            height: 34px;
            border: 1px solid #e69500;
        }
        
        .btn-orange:hover {
            background: #e69500;
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(255,165,0,0.2);
        }
        
        .btn-orange i {
            font-size: 12px !important;
        }
        
        .btn-red { 
            background: #f44336; 
            color: white; 
            padding: 7px 14px; 
            border: none; 
            border-radius: 5px; 
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            cursor: pointer;
            height: 34px;
            border: 1px solid #d32f2f;
        }
        
        .btn-red:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(244,67,54,0.2);
        }
        
        .btn-red i {
            font-size: 12px !important;
        }
        
        /* ========== TABLE ========== */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }
        
        th { 
            background: #795548; 
            color: white; 
            padding: 14px 15px; 
            text-align: left; 
            font-weight: bold;
            font-size: 13px;
            white-space: nowrap;
        }
        
        th i {
            margin-right: 8px;
            font-size: 13px;
        }
        
        td { 
            padding: 14px 15px; 
            border-bottom: 1px solid #f0f0f0; 
            vertical-align: middle;
        }
        
        tr:hover { 
            background: #F8F9FA; 
        }
        
        .archived-row {
            background-color: #FFF9E6;
        }
        
        .archived-row:hover {
            background-color: #FFF3CC;
        }
        
        .profile-pic { 
            width: 38px; 
            height: 38px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 2px solid #e0e0e0;
        }
        
        /* ========== BADGES ========== */
        .badge { 
            padding: 5px 10px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-archived { 
            background: #FFECB3; 
            color: #FF8F00;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .badge-archived i {
            font-size: 10px !important;
        }
        
        .badge-male { 
            background: #E3F2FD; 
            color: #1565C0; 
        }
        
        .badge-female { 
            background: #FCE4EC; 
            color: #C2185B; 
        }
        
        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 70px;
            color: #FFD54F;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .empty-state h2 {
            margin-bottom: 10px;
            color: #795548;
            font-size: 20px;
        }
        
        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        /* ========== STATISTICS ========== */
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin: 25px 0;
            gap: 15px;
        }
        
        .stat-card {
            flex: 1;
            background: white;
            padding: 18px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-card h3 {
            color: #008080;
            margin-bottom: 10px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        .stat-card h3 i {
            font-size: 14px;
        }
        
        .stat-card .value {
            font-size: 28px;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .stat-card.archive .value { color: #FF9800; }
        .stat-card.male .value { color: #2196F3; }
        .stat-card.female .value { color: #E91E63; }
        .stat-card.average .value { color: #795548; font-size: 16px; }
        
        /* ========== USER INFO ========== */
        .user-info {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 10px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #008080;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid #008080;
            object-fit: cover;
        }
        
        .welcome-text {
            font-size: 13px;
            color: #666;
        }
        
        .welcome-text strong {
            color: #008080;
            font-size: 14px;
        }
        
        .timestamp {
            font-size: 11px; 
            color: #888;
            margin-top: 2px;
        }
        
        /* ========== FLASH MESSAGES ========== */
        .alert-success {
            background: #d4edda; 
            color: #155724; 
            padding: 12px 18px; 
            border-radius: 6px; 
            margin-bottom: 18px; 
            border-left: 4px solid #28a745;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }
        
        .alert-error {
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px 18px; 
            border-radius: 6px; 
            margin-bottom: 18px; 
            border-left: 4px solid #dc3545;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }
        
        /* ========== ACTIONS CELL ========== */
        .actions-cell {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            min-width: 180px;
        }
        
        .actions-cell form {
            margin: 0;
        }
        
        /* ========== INFO BOX ========== */
        .info-box {
            background: #FFF3CD; 
            border-left: 4px solid #FFC107; 
            padding: 15px 18px; 
            margin-top: 20px; 
            border-radius: 6px;
        }
        
        .info-box h4 {
            color: #856404; 
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }
        
        .info-box h4 i {
            font-size: 14px;
        }
        
        .info-box p {
            color: #856404; 
            font-size: 13px; 
            margin: 0;
            line-height: 1.5;
        }
        
        /* ========== PAGINATION ========== */
        .pagination-container {
            text-align: center; 
            margin-top: 20px;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .stats-container {
                flex-wrap: wrap;
            }
            
            .stat-card {
                min-width: calc(50% - 8px);
            }
        }
        
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
                padding: 15px;
            }
            
            .nav-menu a {
                justify-content: center;
                padding: 12px;
            }
            
            .nav-menu i {
                margin-right: 0;
                font-size: 16px;
            }
            
            .header {
                flex-direction: column;
                gap: 12px;
                text-align: center;
                padding: 15px;
            }
            
            .stats-container {
                flex-direction: column;
                gap: 12px;
            }
            
            .stat-card {
                min-width: 100%;
                padding: 15px;
            }
            
            .btn-action-group {
                justify-content: center;
            }
            
            .actions-cell {
                flex-direction: column;
                gap: 6px;
            }
            
            .btn-orange, .btn-red {
                width: 100%;
            }
            
            h1 {
                font-size: 20px;
            }
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 18px;
            }
            
            .btn-back, .btn-empty-state {
                padding: 8px 14px;
                font-size: 13px;
                height: 36px;
            }
            
            .empty-state i {
                font-size: 60px;
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
            
            <li><a href="{{ route('archives.index') }}" class="active">
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
        
        <!-- Page Header -->
        <div class="header">
            <h1><i class="fas fa-archive"></i> Archived Students</h1>
            <div class="btn-action-group">
                <a href="{{ route('students.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Students
                </a>
            </div>
        </div>
        
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
        @endif
        
        <!-- Statistics -->
        <div class="stats-container">
            <div class="stat-card archive">
                <h3><i class="fas fa-archive"></i> Total Archived</h3>
                <div class="value">{{ $students->total() }}</div>
            </div>
            
            <div class="stat-card male">
                <h3><i class="fas fa-male"></i> Male</h3>
                <div class="value">
                    {{ $students->where('gender', 'Male')->count() }}
                </div>
            </div>
            
            <div class="stat-card female">
                <h3><i class="fas fa-female"></i> Female</h3>
                <div class="value">
                    {{ $students->where('gender', 'Female')->count() }}
                </div>
            </div>
            
            <div class="stat-card average">
                <h3><i class="fas fa-calendar-times"></i> Latest Archive</h3>
                <div class="value">
                    @if($students->count() > 0 && $students->first()->deleted_at)
                        {{ $students->first()->deleted_at->format('M d, Y') }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Archived Students Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Student</th>
                        <th><i class="fas fa-id-card"></i> Student ID</th>
                        <th><i class="fas fa-users"></i> Section</th>
                        <th><i class="fas fa-graduation-cap"></i> Year Level</th>
                        <th><i class="fas fa-venus-mars"></i> Gender</th>
                        <th><i class="fas fa-calendar-times"></i> Archived Date</th>
                        <th><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($students->count() > 0)
                        @foreach($students as $student)
                        <tr class="archived-row">
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $student->name }}" 
                                         class="profile-pic">
                                    <div style="margin-left: 10px;">
                                        <strong style="font-size: 14px;">{{ $student->name }}</strong><br>
                                        <small style="color: #666; font-size: 11px;">{{ $student->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size: 12px;"><code>{{ $student->student_number }}</code></td>
                            <td style="font-size: 13px;">{{ $student->section }}</td>
                            <td style="font-size: 13px;">{{ $student->year_level }}</td>
                            <td>
                                <span class="badge {{ $student->gender == 'Male' ? 'badge-male' : 'badge-female' }}">
                                    {{ $student->gender }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-archived">
                                    <i class="fas fa-calendar"></i> 
                                    @if($student->deleted_at)
                                        {{ $student->deleted_at->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <form action="{{ route('archives.restore', $student->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-orange" title="Restore Student">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('archives.forceDelete', $student->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-red" title="Permanently Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-archive"></i>
                                    <h2>Archive is Empty</h2>
                                    <p>No archived students found. When you delete students, they will appear here.</p>
                                    <a href="{{ route('students.index') }}" class="btn-empty-state" style="margin-top: 15px;">
                                        <i class="fas"></i> Go to Manage Students
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($students->hasPages())
        <div class="pagination-container">
            {{ $students->links() }}
        </div>
        @endif
        
        <!-- Important Note -->
        <div class="info-box">
            <h4>
                <i class="fas fa-exclamation-triangle"></i> Archive Information
            </h4>
            <p>
                • Archived students can be restored to the active list.<br>
                • Restoring brings back all student data including grades.<br>
                • Permanent deletion removes everything forever (cannot be undone).
            </p>
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
            
            // Confirmations for delete actions
            const deleteForms = document.querySelectorAll('form[action*="forceDelete"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('⚠️ WARNING: This will PERMANENTLY delete the student and all their grades. This action cannot be undone. Continue?')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Confirmation for restore
            const restoreForms = document.querySelectorAll('form[action*="restore"]');
            restoreForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Restore this student to the active list?')) {
                        e.preventDefault();
                    }
                });
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
</body>
</html>