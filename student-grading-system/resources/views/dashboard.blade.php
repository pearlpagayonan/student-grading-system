<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Grading System</title>
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
        
        .btn-orange { 
            background: #FFA500; 
            color: white; 
            padding: 8px 15px; 
            border: none; 
            border-radius: 5px; 
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .btn-orange:hover {
            background: #e69500;
        }
        
        /* Dashboard Cards */
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 15px;
        }
        
        .stat-card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card h3 {
            color: #008080;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
        }
        
        .stat-card.total .value { color: #FFA500; }
        .stat-card.male .value { color: #2196F3; }
        .stat-card.female .value { color: #E91E63; }
        .stat-card.average .value { color: #4CAF50; }
        
        /* Charts Container */
        .charts-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-box {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: 300px;
        }
        
        .chart-box h3 {
            color: #008080;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        /* Top Students Table */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th { 
            background: #008080;
            color: white; 
            padding: 15px; 
            text-align: left; 
            font-weight: bold;
        }
        
        td { 
            padding: 15px; 
            border-bottom: 1px solid #eee; 
        }
        
        tr:hover { 
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
        
        .badge-excellent { background: #E8F5E9; color: #2E7D32; }
        .badge-good { background: #E3F2FD; color: #1565C0; }
        .badge-average { background: #FFF3E0; color: #EF6C00; }
        .badge-needs-help { background: #FFEBEE; color: #C62828; }
        
        /* Section List */
        .section-list {
            list-style: none;
            padding: 0;
        }
        
        .section-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        
        .section-item:last-child {
            border-bottom: none;
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
        
        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .quick-action-btn {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }
        
        .quick-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .quick-action-btn i {
            font-size: 24px;
            margin-bottom: 10px;
            display: block;
        }
        
        .quick-action-btn.add-student { border-top: 4px solid #FFA500; }
        .quick-action-btn.manage-grades { border-top: 4px solid #4CAF50; }
        .quick-action-btn.view-archives { border-top: 4px solid #9C27B0; }
        .quick-action-btn.settings { border-top: 4px solid #2196F3; }
        
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
            
            .stats-container,
            .charts-container {
                flex-direction: column;
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
            <li><a href="{{ route('dashboard') }}" class="active">
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
            <h1><i class="fas fa-chart-line"></i> 📊 Dashboard Overview</h1>

        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-container">
            <div class="stat-card total">
                <h3><i class="fas fa-users"></i> Total Students</h3>
                <div class="value">{{ $totalStudents }}</div>
                <div style="font-size: 12px; color: #888;">Active Students</div>
            </div>
            
            <div class="stat-card male">
                <h3><i class="fas fa-male"></i> Male Students</h3>
                <div class="value">{{ $maleStudents }}</div>
                <div style="font-size: 12px; color: #888;">
                    {{ $totalStudents > 0 ? round(($maleStudents/$totalStudents)*100, 1) : 0 }}%
                </div>
            </div>
            
            <div class="stat-card female">
                <h3><i class="fas fa-female"></i> Female Students</h3>
                <div class="value">{{ $femaleStudents }}</div>
                <div style="font-size: 12px; color: #888;">
                    {{ $totalStudents > 0 ? round(($femaleStudents/$totalStudents)*100, 1) : 0 }}%
                </div>
            </div>
            
            <div class="stat-card average">
                <h3><i class="fas fa-star"></i> Average GPA</h3>
                <div class="value">
                    {{ number_format(collect($topStudents ?? [])->avg('average_grade') ?? 0, 2) }}
                </div>
                <div style="font-size: 12px; color: #888;">Overall Average</div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="charts-container">
            <!-- Section Distribution -->
            <div class="chart-box">
                <h3><i class="fas fa-layer-group"></i> Section Distribution</h3>
                @if($sections->count() > 0)
                    <ul class="section-list">
                        @foreach($sections as $section)
                            <li class="section-item">
                                <span>
                                    <i class="fas fa-folder" style="color: #008080;"></i>
                                    <strong>{{ $section->section }}</strong>
                                </span>
                                <span style="background: #FFA500; color: white; padding: 3px 8px; border-radius: 10px;">
                                    {{ $section->total }} students
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-info-circle" style="font-size: 40px; margin-bottom: 10px;"></i>
                        <p>No section data available</p>
                    </div>
                @endif
            </div>
            
            <!-- Grade Distribution -->
            <div class="chart-box">
                <h3><i class="fas fa-chart-pie"></i> Grade Distribution</h3>
                @if(isset($gradeDistribution))
                    <div style="padding: 10px;">
                        <div style="margin-bottom: 15px; display: flex; align-items: center;">
                            <div style="width: 15px; height: 15px; background: #4CAF50; margin-right: 10px; border-radius: 3px;"></div>
                            <div style="flex: 1;">90-100 (Excellent)</div>
                            <strong>{{ $gradeDistribution['90-100'] ?? 0 }}</strong>
                        </div>
                        <div style="margin-bottom: 15px; display: flex; align-items: center;">
                            <div style="width: 15px; height: 15px; background: #2196F3; margin-right: 10px; border-radius: 3px;"></div>
                            <div style="flex: 1;">80-89 (Very Good)</div>
                            <strong>{{ $gradeDistribution['80-89'] ?? 0 }}</strong>
                        </div>
                        <div style="margin-bottom: 15px; display: flex; align-items: center;">
                            <div style="width: 15px; height: 15px; background: #FF9800; margin-right: 10px; border-radius: 3px;"></div>
                            <div style="flex: 1;">70-79 (Good)</div>
                            <strong>{{ $gradeDistribution['70-79'] ?? 0 }}</strong>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <div style="width: 15px; height: 15px; background: #F44336; margin-right: 10px; border-radius: 3px;"></div>
                            <div style="flex: 1;">Below 70 (Needs Help)</div>
                            <strong>{{ $gradeDistribution['Below 70'] ?? 0 }}</strong>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-chart-bar" style="font-size: 40px; margin-bottom: 10px;"></i>
                        <p>No grade data available</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Top Students Table -->
        <div class="table-container">
            <h3 style="padding: 15px 20px; background: #008080; color: white; margin: 0;">
                <i class="fas fa-trophy"></i> Top 10 Performing Students
            </h3>
            
            @if(isset($topStudents) && $topStudents->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Student</th>
                            <th>Section</th>
                            <th>Average Grade</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topStudents as $index => $student)
                        <tr>
                            <td style="text-align: center; font-weight: bold;">
                                @if($index == 0)
                                    <span style="color: #FFD700;">🥇</span>
                                @elseif($index == 1)
                                    <span style="color: #C0C0C0;">🥈</span>
                                @elseif($index == 2)
                                    <span style="color: #CD7F32;">🥉</span>
                                @else
                                    #{{ $index + 1 }}
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $student->name }}" 
                                         class="profile-pic">
                                    <div style="margin-left: 10px;">
                                        <strong>{{ $student->name }}</strong><br>
                                        <small style="color: #666;">{{ $student->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->section }}</td>
                            <td>
                                <span style="font-weight: bold; font-size: 16px;">
                                    {{ number_format($student->average_grade, 2) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $grade = $student->average_grade ?? 0;
                                    $badgeClass = 'badge-needs-help';
                                    $performance = 'Needs Help';
                                    if($grade >= 90) {
                                        $badgeClass = 'badge-excellent';
                                        $performance = 'Excellent';
                                    } elseif($grade >= 80) {
                                        $badgeClass = 'badge-good';
                                        $performance = 'Very Good';
                                    } elseif($grade >= 70) {
                                        $badgeClass = 'badge-average';
                                        $performance = 'Good';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $performance }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-users" style="font-size: 40px; margin-bottom: 10px;"></i>
                    <h3>No Top Students Yet</h3>
                    <p>Add students and their grades to see performance rankings.</p>
                </div>
            @endif
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