<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Grades - Grading System</title>
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
        
        .btn-orange { 
            background: #FFA500; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            cursor: pointer;
        }
        
        .btn-orange:hover {
            background: #e69500;
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
            margin-left: 10px;
            cursor: pointer;
        }
        
        .btn-teal:hover {
            background: #006666;
        }
        
        /* Table Styles */
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
            background: #F0F8FF; 
        }
        
        .grade-excellent { color: #4CAF50; font-weight: bold; }
        .grade-good { color: #2196F3; font-weight: bold; }
        .grade-average { color: #FF9800; font-weight: bold; }
        .grade-poor { color: #f44336; font-weight: bold; }
        
        .badge { 
            padding: 5px 10px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold;
        }
        
        .badge-success { background: #E8F5E9; color: #2E7D32; }
        .badge-warning { background: #FFF3E0; color: #EF6C00; }
        .badge-danger { background: #FFEBEE; color: #C62828; }
        
        /* Filters */
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .filter-group {
            flex: 1;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #008080;
        }
        
        .filter-group select, .filter-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        /* Statistics Cards */
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .stat-card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-card h3 {
            color: #008080;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #FFA500;
        }
        
        .stat-card.good .value { color: #4CAF50; }
        .stat-card.average .value { color: #2196F3; }
        .stat-card.poor .value { color: #f44336; }
        
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
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            width: 500px;
            border-radius: 10px;
            padding: 25px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .modal-wide {
            width: 700px;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        
        .btn-small-orange {
            background: #FFA500;
            color: white;
        }
        
        .btn-small-teal {
            background: #008080;
            color: white;
        }
        
        .btn-small-red {
            background: #f44336;
            color: white;
        }
        
        .btn-small-green {
            background: #4CAF50;
            color: white;
        }
        
        /* Grades Table in Modal */
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .grades-table th {
            background: #f8f9fa;
            color: #008080;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        
        .grades-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        
        .grades-table tr:hover {
            background: #f0f8ff;
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
            
            .filters {
                flex-direction: column;
            }
            
            .stats-container {
                flex-direction: column;
            }
            
            .modal-content {
                width: 95%;
                margin: 10px;
            }
            
            .modal-wide {
                width: 95%;
            }
        }
        
        /* Subject Badge */
        .subject-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1565c0;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin: 2px;
            border: 1px solid #bbdefb;
        }
        
        .subject-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 5px;
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
            
            <li><a href="{{ route('grades.manage') }}" class="active">
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
            <h1><i class="fas fa-graduation-cap"></i> 📊 Manage Students & Grades</h1>
            <div>
                <a href="#" class="btn-teal">
                    <i class="fas fa-download"></i> Export
                </a>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filters">
            <div class="filter-group">
                <label><i class="fas fa-user-graduate"></i> Search Student</label>
                <input type="text" id="searchStudent" placeholder="Type student name or ID...">
            </div>
            
            <div class="filter-group">
                <label><i class="fas fa-filter"></i> Grade Status</label>
                <select id="filterStatus">
                    <option value="">All Students</option>
                    <option value="with-grades">With Grades</option>
                    <option value="no-grades">No Grades Yet</option>
                </select>
            </div>
        </div>
        
        <!-- Students Table -->
        <div class="table-container">
            <table id="studentsTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Student</th>
                        <th><i class="fas fa-id-card"></i> Student ID</th>
                        <th><i class="fas fa-graduation-cap"></i> Subjects & Grades</th>
                        <th><i class="fas fa-star"></i> Average Grade</th>
                        <th><i class="fas fa-chart-line"></i> Status</th>
                        <th><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($students->count() > 0)
                        @foreach($students as $student)
                        @php
                            $gradesCount = $student->grades->count();
                            $averageGrade = $gradesCount > 0 ? $student->grades->avg('grade') : 0;
                            
                            $statusClass = 'badge-warning';
                            $statusText = 'No Grades';
                            
                            if($averageGrade >= 90) {
                                $statusClass = 'badge-success';
                                $statusText = 'Excellent';
                            } elseif($averageGrade >= 80) {
                                $statusClass = 'badge-success';
                                $statusText = 'Good';
                            } elseif($averageGrade >= 75) {
                                $statusClass = 'badge-warning';
                                $statusText = 'Average';
                            } elseif($averageGrade > 0) {
                                $statusClass = 'badge-danger';
                                $statusText = 'Needs Improvement';
                            }
                        @endphp
                        <tr data-student-id="{{ $student->id }}">
                            <td>
                                <div style="display: flex; align-items: center;">
                                    @if($student->profile_picture)
                                        <img src="{{ asset('storage/' . $student->profile_picture) }}" 
                                             alt="{{ $student->name }}" 
                                             style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px;">
                                    @else
                                        @php
                                            $gender = strtolower($student->gender ?? 'other');
                                            $avatarStyle = ($gender == 'female') ? 'avataaars' : 'avataaars';
                                            $avatarUrl = "https://api.dicebear.com/7.x/{$avatarStyle}/svg?seed=" . urlencode($student->name) . "&backgroundColor=008080&textColor=ffffff";
                                        @endphp
                                        <img src="{{ $avatarUrl }}" 
                                             alt="{{ $student->name }}" 
                                             style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px;">
                                    @endif
                                    <div>
                                        <div style="font-weight: bold;">{{ $student->name }}</div>
                                        <div style="font-size: 12px; color: #666;">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $student->student_number ?? 'N/A' }}</code></td>
                            <td>
                                @if($gradesCount > 0)
                                    <div style="font-size: 12px; color: #666;">
                                        <strong>{{ $gradesCount }} subject(s)</strong>
                                    </div>
                                    <div class="subject-list">
                                        @foreach($student->grades->take(3) as $grade)
                                            <span class="subject-badge" title="{{ $grade->subject }}: {{ $grade->grade }}">
                                                {{ Str::limit($grade->subject, 15) }}: {{ $grade->grade }}
                                            </span>
                                        @endforeach
                                        @if($gradesCount > 3)
                                            <span class="subject-badge" style="background: #f0f0f0; color: #666;">
                                                +{{ $gradesCount - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: #999; font-style: italic;">No grades yet</span>
                                @endif
                            </td>
                            <td>
                                @if($gradesCount > 0)
                                    <span style="font-weight: bold; font-size: 16px; 
                                        @if($averageGrade >= 90) color: #4CAF50;
                                        @elseif($averageGrade >= 80) color: #2196F3;
                                        @elseif($averageGrade >= 75) color: #FF9800;
                                        @else color: #f44336; @endif">
                                        {{ number_format($averageGrade, 2) }}
                                    </span>
                                @else
                                    <span style="color: #999; font-style: italic;">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                <button onclick="showAddGradeModal('{{ $student->id }}', '{{ $student->name }}', '{{ $student->student_number ?? '' }}')" 
                                        class="btn-small btn-small-orange" style="margin-bottom: 5px;">
                                    <i class="fas fa-plus"></i> Add Grade
                                </button>
                                
                                @if($student->grades->count() > 0)
                                <button onclick="viewStudentGrades('{{ $student->id }}', '{{ $student->name }}')" 
                                        class="btn-small btn-small-teal">
                                    <i class="fas fa-eye"></i> View Grades
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                                <i class="fas fa-users" style="font-size: 50px; margin-bottom: 15px; color: #ccc;"></i>
                                <h3 style="margin-bottom: 10px;">No Students Found</h3>
                                <p>Add students first in the "Manage Students" page.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Statistics -->
        <div class="stats-container">
            <div class="stat-card">
                <h3><i class="fas fa-users"></i> Total Students</h3>
                <div class="value">{{ $students->count() }}</div>
            </div>
            
            <div class="stat-card good">
                <h3><i class="fas fa-check-circle"></i> With Grades</h3>
                <div class="value">
                    {{ $students->filter(function($student) { return $student->grades->count() > 0; })->count() }}
                </div>
            </div>
            
            <div class="stat-card average">
                <h3><i class="fas fa-chart-line"></i> Overall Average</h3>
                <div class="value">
                    @php
                        $allGrades = collect();
                        foreach($students as $student) {
                            $allGrades = $allGrades->merge($student->grades->pluck('grade'));
                        }
                        $overallAverage = $allGrades->count() > 0 ? $allGrades->avg() : 0;
                    @endphp
                    {{ number_format($overallAverage, 2) }}
                </div>
            </div>
            
            <div class="stat-card">
                <h3><i class="fas fa-graduation-cap"></i> Total Grades</h3>
                <div class="value">
                    @php
                        $totalGrades = 0;
                        foreach($students as $student) {
                            $totalGrades += $student->grades->count();
                        }
                    @endphp
                    {{ $totalGrades }}
                </div>
            </div>
        </div>
        
        <!-- Pagination for Students -->
        @if(method_exists($students, 'hasPages') && $students->hasPages())
        <div style="text-align: center; margin-top: 20px;">
            {{ $students->links() }}
        </div>
        @endif
    </div>
    
    <!-- Add Grade Modal -->
    <div id="addGradeModal" class="modal-overlay">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="color: #008080; margin: 0;">
                    <i class="fas fa-plus"></i> Add New Grade
                </h2>
                <button onclick="hideAddGradeModal()" 
                        style="background: none; border: none; font-size: 20px; color: #888; cursor: pointer;">×</button>
            </div>
            
            <form id="addGradeForm">
                @csrf
                <input type="hidden" name="student_number" id="modalStudentNumber">

                <div style="margin-bottom: 15px; background: #f8f9fa; padding: 15px; border-radius: 5px;">
                    <div style="font-weight: bold; color: #008080; margin-bottom: 5px;">
                        <i class="fas fa-user-graduate"></i> Selected Student
                    </div>
                    <div id="selectedStudentName" style="font-size: 16px; font-weight: bold;">None selected</div>
                    <div id="selectedStudentInfo" style="font-size: 12px; color: #666; margin-top: 5px;">
                        Student ID: <span id="selectedStudentId"></span> | 
                        Student #: <span id="selectedStudentNumber"></span>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                        <i class="fas fa-book"></i> Subject *
                    </label>
                    <input type="text" name="subject" id="gradeSubject" required 
                           placeholder="e.g., Mathematics, Science, English, Filipino"
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                            <i class="fas fa-star"></i> Grade (0-100) *
                        </label>
                        <input type="number" name="grade" id="gradeValue" step="0.01" min="0" max="100" required 
                               placeholder="95.50"
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                            <i class="fas fa-balance-scale"></i> Units *
                        </label>
                        <input type="number" name="units" id="gradeUnits" min="1" max="5" value="3" required 
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                            <i class="fas fa-calendar"></i> School Year *
                        </label>
                        <select name="school_year" id="gradeSchoolYear" required 
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            <option value="2024-2025">2024-2025</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                            <i class="fas fa-calendar-alt"></i> Semester *
                        </label>
                        <select name="semester" id="gradeSemester" required 
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                            <option value="Summer">Summer</option>
                        </select>
                    </div>
                </div>
                
                <div style="text-align: right;">
                    <button type="button" onclick="hideAddGradeModal()" 
                            style="background: #ccc; color: #333; padding: 10px 20px; border: none; border-radius: 5px; margin-right: 10px; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" id="submitGradeBtn"
                            style="background: #FFA500; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                        <i class="fas fa-save"></i> Save Grade
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- View Grades Modal -->
    <div id="viewGradesModal" class="modal-overlay">
        <div class="modal-content modal-wide">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="color: #008080; margin: 0;">
                    <i class="fas fa-graduation-cap"></i> Student Grades
                </h2>
                <button onclick="hideViewGradesModal()" 
                        style="background: none; border: none; font-size: 20px; color: #888; cursor: pointer;">×</button>
            </div>
            
            <div id="studentGradesInfo" style="margin-bottom: 20px; background: #f8f9fa; padding: 15px; border-radius: 5px;">
                <div style="font-weight: bold; color: #008080; margin-bottom: 5px;">
                    <i class="fas fa-user-graduate"></i> Student Information
                </div>
                <div id="viewStudentName" style="font-size: 16px; font-weight: bold;"></div>
                <div id="viewStudentDetails" style="font-size: 12px; color: #666; margin-top: 5px;"></div>
            </div>
            
            <div id="gradesSummary" style="display: flex; gap: 10px; margin-bottom: 20px;">
                <div style="flex: 1; background: #e3f2fd; padding: 10px; border-radius: 5px; text-align: center;">
                    <div style="font-size: 12px; color: #1565c0;">Total Subjects</div>
                    <div id="totalSubjects" style="font-size: 24px; font-weight: bold; color: #1565c0;">0</div>
                </div>
                <div style="flex: 1; background: #e8f5e9; padding: 10px; border-radius: 5px; text-align: center;">
                    <div style="font-size: 12px; color: #2e7d32;">Average Grade</div>
                    <div id="averageGrade" style="font-size: 24px; font-weight: bold; color: #2e7d32;">0.00</div>
                </div>
                <div style="flex: 1; background: #fff3e0; padding: 10px; border-radius: 5px; text-align: center;">
                    <div style="font-size: 12px; color: #ef6c00;">Total Units</div>
                    <div id="totalUnits" style="font-size: 24px; font-weight: bold; color: #ef6c00;">0</div>
                </div>
            </div>
            
            <div id="gradesTableContainer">
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-book"></i> Subject</th>
                            <th><i class="fas fa-star"></i> Grade</th>
                            <th><i class="fas fa-balance-scale"></i> Units</th>
                            <th><i class="fas fa-calendar"></i> School Year</th>
                            <th><i class="fas fa-calendar-alt"></i> Semester</th>
                            <th><i class="fas fa-clock"></i> Date Added</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody id="gradesTableBody">
                        <!-- Grades will be loaded here -->
                    </tbody>
                </table>
            </div>
            
            <div style="text-align: center; margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; display: none;" id="noGradesMessage">
                <i class="fas fa-graduation-cap" style="font-size: 40px; color: #ccc; margin-bottom: 10px;"></i>
                <h3 style="margin-bottom: 10px; color: #666;">No Grades Found</h3>
                <p style="color: #888;">This student doesn't have any grades yet.</p>
            </div>
            
            <div style="text-align: right; margin-top: 20px;">
                <button onclick="hideViewGradesModal()" 
                        style="background: #ccc; color: #333; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                    Close
                </button>
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
            
            // Filter functionality
            const searchInput = document.getElementById('searchStudent');
            const filterStatus = document.getElementById('filterStatus');
            
            searchInput.addEventListener('input', filterTable);
            filterStatus.addEventListener('change', filterTable);
        });
        
        // Show Add Grade Modal
        function showAddGradeModal(studentId = '', studentName = '', studentNumber = '') {
            console.log('Opening modal with:', { studentId, studentName, studentNumber });
            
            // Get the student_number input
            const studentNumberInput = document.getElementById('modalStudentNumber');
            
            // Set student_number
            if (studentNumber && studentNumber !== 'undefined') {
                studentNumberInput.value = studentNumber;
                console.log('Set student_number to:', studentNumberInput.value);
            } else {
                console.error('No student_number provided!');
                alert('Error: Student number is required');
                return;
            }
            
            // Update display
            document.getElementById('selectedStudentName').textContent = studentName || 'Unknown';
            document.getElementById('selectedStudentId').textContent = studentId;
            document.getElementById('selectedStudentNumber').textContent = studentNumber || 'N/A';
            
            // Reset form
            document.getElementById('gradeSubject').value = '';
            document.getElementById('gradeValue').value = '';
            document.getElementById('gradeUnits').value = '3';
            document.getElementById('gradeSchoolYear').value = '2024-2025';
            document.getElementById('gradeSemester').value = '1st Semester';
            
            // Show modal
            document.getElementById('addGradeModal').style.display = 'flex';
        }
        
        // Hide Add Grade Modal
        function hideAddGradeModal() {
            document.getElementById('addGradeModal').style.display = 'none';
        }
        
        // Show View Grades Modal
        async function viewStudentGrades(studentId, studentName) {
            console.log('Viewing grades for student:', studentId, studentName);
            
            // Show loading
            document.getElementById('viewGradesModal').style.display = 'flex';
            document.getElementById('gradesTableBody').innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #008080;"></i>
                        <div style="margin-top: 10px; color: #666;">Loading grades...</div>
                    </td>
                </tr>
            `;
            
            // Set student info
            document.getElementById('viewStudentName').textContent = studentName;
            document.getElementById('viewStudentDetails').textContent = `Student ID: ${studentId}`;
            
            try {
                // Fetch student grades
                const response = await fetch(`/grades/student/${studentId}`);
                const data = await response.json();
                
                console.log('Grades data:', data);
                
                if (data.success && data.grades.length > 0) {
                    // Update summary
                    document.getElementById('totalSubjects').textContent = data.grades.length;
                    document.getElementById('averageGrade').textContent = data.average.toFixed(2);
                    document.getElementById('totalUnits').textContent = data.totalUnits;
                    
                    // Show grades table
                    document.getElementById('noGradesMessage').style.display = 'none';
                    document.getElementById('gradesTableContainer').style.display = 'block';
                    
                    // Populate grades table
                    let gradesHtml = '';
                    data.grades.forEach(grade => {
                        const gradeColor = getGradeColor(grade.grade);
                        const dateAdded = new Date(grade.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                        
                        gradesHtml += `
                            <tr>
                                <td>${grade.subject}</td>
                                <td><span style="color: ${gradeColor}; font-weight: bold;">${grade.grade}</span></td>
                                <td>${grade.units}</td>
                                <td>${grade.school_year}</td>
                                <td>${grade.semester}</td>
                                <td>${dateAdded}</td>
                                <td>
                                    <button onclick="editGrade(${grade.id})" class="btn-small" style="background: #FFA500; color: white;">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="deleteGrade(${grade.id})" class="btn-small" style="background: #f44336; color: white;">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    document.getElementById('gradesTableBody').innerHTML = gradesHtml;
                } else {
                    // No grades found
                    document.getElementById('totalSubjects').textContent = '0';
                    document.getElementById('averageGrade').textContent = '0.00';
                    document.getElementById('totalUnits').textContent = '0';
                    document.getElementById('noGradesMessage').style.display = 'block';
                    document.getElementById('gradesTableContainer').style.display = 'none';
                }
            } catch (error) {
                console.error('Error loading grades:', error);
                document.getElementById('gradesTableBody').innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #f44336;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>Error loading grades. Please try again.</div>
                        </td>
                    </tr>
                `;
            }
        }
        
        // Hide View Grades Modal
        function hideViewGradesModal() {
            document.getElementById('viewGradesModal').style.display = 'none';
        }
        
        // Form submission handler
        document.getElementById('addGradeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('=== FORM SUBMISSION ===');
            
            // Get student_number
            const studentNumber = document.getElementById('modalStudentNumber').value;
            
            if (!studentNumber) {
                alert('❌ ERROR: Student number is required!');
                return;
            }
            
            // Create FormData
            const formData = new FormData(this);
            
            // Ensure student_number is included
            formData.append('student_number', studentNumber);
            
            console.log('Sending data:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            
            // Show loading
            const submitBtn = document.getElementById('submitGradeBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            
            // Send request
            fetch('{{ route("grades.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                
                if (data.success) {
                    alert('✅ ' + data.message);
                    hideAddGradeModal();
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    alert('❌ Error: ' + data.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Network error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
        
        // Close modals when clicking outside
        document.getElementById('addGradeModal').addEventListener('click', function(e) {
            if (e.target.id === 'addGradeModal') {
                hideAddGradeModal();
            }
        });
        
        document.getElementById('viewGradesModal').addEventListener('click', function(e) {
            if (e.target.id === 'viewGradesModal') {
                hideViewGradesModal();
            }
        });
        
        // Filter table
        function filterTable() {
            const searchText = document.getElementById('searchStudent').value.toLowerCase();
            const filterStatus = document.getElementById('filterStatus').value;
            const rows = document.querySelectorAll('#studentsTable tbody tr');
            
            rows.forEach(row => {
                const studentName = row.cells[0].textContent.toLowerCase();
                const studentId = row.cells[1].textContent.toLowerCase();
                const gradesCount = parseInt(row.cells[2].querySelector('strong')?.textContent || '0');
                const status = row.cells[4].textContent;
                
                let showRow = true;
                
                // Search filter
                if (searchText && !studentName.includes(searchText) && !studentId.includes(searchText)) {
                    showRow = false;
                }
                
                // Status filter
                if (filterStatus === 'with-grades' && gradesCount === 0) {
                    showRow = false;
                } else if (filterStatus === 'no-grades' && gradesCount > 0) {
                    showRow = false;
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }
        
        // Helper function to get grade color
        function getGradeColor(grade) {
            if (grade >= 90) return '#4CAF50';
            if (grade >= 80) return '#2196F3';
            if (grade >= 75) return '#FF9800';
            return '#f44336';
        }
        
        // Edit grade function (placeholder)
       // Edit grade function
async function editGrade(gradeId) {
    console.log('Editing grade ID:', gradeId);
    
    try {
        // First, get the current grade details
        const response = await fetch(`/grades/${gradeId}/edit`);
        const data = await response.json();
        
        if (data.success) {
            // Show edit modal
            showEditGradeModal(data.grade);
        } else {
            alert('❌ Error loading grade: ' + data.message);
        }
    } catch (error) {
        console.error('Error loading grade:', error);
        alert('❌ Error loading grade details');
    }
}

// Delete grade function
// Delete grade function - FIXED VERSION
async function deleteGrade(gradeId, gradeSubject) {
    if (!confirm(`Are you sure you want to delete this grade?\n\n\nThis action cannot be undone.`)) {
        return;
    }
    
    console.log('Deleting grade ID:', gradeId);
    
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    
    try {
        const response = await fetch(`/grades/${gradeId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        // Check if response is OK first
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Try to parse as JSON
        let data;
        try {
            data = await response.json();
        } catch (jsonError) {
            console.log('Response is not JSON, assuming success');
            data = { success: true, message: 'Grade deleted successfully!' };
        }
        
        if (data.success) {
            alert('✅ ' + data.message);
            
            // Refresh the grades table
            const currentStudentId = window.currentStudentId;
            const currentStudentName = window.currentStudentName;
            
            if (currentStudentId && currentStudentName) {
                // Close view modal and reopen to refresh
                hideViewGradesModal();
                setTimeout(() => {
                    viewStudentGrades(currentStudentId, currentStudentName);
                }, 500);
            }
        } else {
            alert('❌ Error: ' + (data.message || 'Unknown error'));
        }
        
    } catch (error) {
        console.error('Error deleting grade:', error);
        
        // Check if grade was deleted anyway (sometimes it works despite error)
        setTimeout(async () => {
            try {
                // Verify if grade was actually deleted
                const verifyResponse = await fetch(`/grades/${gradeId}/exists`);
                if (verifyResponse.status === 404) {
                    // Grade was deleted despite error
                    alert('✅ Grade was deleted successfully!');
                    // Refresh the grades table
                    const currentStudentId = window.currentStudentId;
                    const currentStudentName = window.currentStudentName;
                    if (currentStudentId && currentStudentName) {
                        hideViewGradesModal();
                        setTimeout(() => {
                            viewStudentGrades(currentStudentId, currentStudentName);
                        }, 500);
                    }
                } else {
                    alert('❌ Error deleting grade: ' + error.message);
                }
            } catch (verifyError) {
                console.error('Verify error:', verifyError);
                alert('❌ Error deleting grade. Please refresh the page to check.');
            }
        }, 1000);
    }
}

// Helper function to track current student
let currentStudentId = null;
let currentStudentName = null;

// Update viewStudentGrades function to track current student
async function viewStudentGrades(studentId, studentName) {
    console.log('Viewing grades for student:', studentId, studentName);
    
    // Store current student info
    window.currentStudentId = studentId;
    window.currentStudentName = studentName;
    
    // Show loading
    document.getElementById('viewGradesModal').style.display = 'flex';
    document.getElementById('gradesTableBody').innerHTML = `
        <tr>
            <td colspan="7" style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #008080;"></i>
                <div style="margin-top: 10px; color: #666;">Loading grades...</div>
            </td>
        </tr>
    `;
    
    // Set student info
    document.getElementById('viewStudentName').textContent = studentName;
    document.getElementById('viewStudentDetails').textContent = `Student ID: ${studentId}`;
    
    try {
        // Fetch student grades
        const response = await fetch(`/grades/student/${studentId}`);
        const data = await response.json();
        
        console.log('Grades data:', data);
        
        if (data.success && data.grades.length > 0) {
            // Update summary
            document.getElementById('totalSubjects').textContent = data.grades.length;
            document.getElementById('averageGrade').textContent = data.average.toFixed(2);
            document.getElementById('totalUnits').textContent = data.totalUnits;
            
            // Show grades table
            document.getElementById('noGradesMessage').style.display = 'none';
            document.getElementById('gradesTableContainer').style.display = 'block';
            
            // Populate grades table
            let gradesHtml = '';
            data.grades.forEach(grade => {
                const gradeColor = getGradeColor(grade.grade);
                const dateAdded = new Date(grade.created_at).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                
                gradesHtml += `
                    <tr>
                        <td>${grade.subject}</td>
                        <td><span style="color: ${gradeColor}; font-weight: bold;">${grade.grade}</span></td>
                        <td>${grade.units}</td>
                        <td>${grade.school_year}</td>
                        <td>${grade.semester}</td>
                        <td>${dateAdded}</td>
                        <td>
                            <button onclick="editGrade(${grade.id})" class="btn-small" style="background: #FFA500; color: white;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="deleteGrade(${grade.id})" class="btn-small" style="background: #f44336; color: white;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            document.getElementById('gradesTableBody').innerHTML = gradesHtml;
        } else {
            // No grades found
            document.getElementById('totalSubjects').textContent = '0';
            document.getElementById('averageGrade').textContent = '0.00';
            document.getElementById('totalUnits').textContent = '0';
            document.getElementById('noGradesMessage').style.display = 'block';
            document.getElementById('gradesTableContainer').style.display = 'none';
        }
    } catch (error) {
        console.error('Error loading grades:', error);
        document.getElementById('gradesTableBody').innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #f44336;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>Error loading grades. Please try again.</div>
                </td>
            </tr>
        `;
    }
}

// Function to show edit grade modal
function showEditGradeModal(grade) {
    console.log('Showing edit modal for grade:', grade);
    
    // Create edit modal HTML
    const editModalHTML = `
        <div class="modal-overlay" id="editGradeModal">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="color: #008080; margin: 0;">
                        <i class="fas fa-edit"></i> Edit Grade
                    </h2>
                    <button onclick="hideEditGradeModal()" 
                            style="background: none; border: none; font-size: 20px; color: #888; cursor: pointer;">×</button>
                </div>
                
                <form id="editGradeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="grade_id" value="${grade.id}">
                    
                    <div style="margin-bottom: 15px; background: #f8f9fa; padding: 15px; border-radius: 5px;">
                        <div style="font-weight: bold; color: #008080; margin-bottom: 5px;">
                            <i class="fas fa-book"></i> Subject
                        </div>
                        <div style="font-size: 16px;">${grade.subject}</div>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                            <i class="fas fa-star"></i> Grade (0-100) *
                        </label>
                        <input type="number" name="grade" id="editGradeValue" step="0.01" min="0" max="100" required 
                               value="${grade.grade}"
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                                <i class="fas fa-balance-scale"></i> Units
                            </label>
                            <input type="number" name="units" id="editGradeUnits" min="1" max="5" value="${grade.units}" required 
                                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                                <i class="fas fa-calendar"></i> School Year
                            </label>
                            <select name="school_year" id="editGradeSchoolYear" required 
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                                <option value="2024-2025" ${grade.school_year === '2024-2025' ? 'selected' : ''}>2024-2025</option>
                                <option value="2023-2024" ${grade.school_year === '2023-2024' ? 'selected' : ''}>2023-2024</option>
                                <option value="2025-2026" ${grade.school_year === '2025-2026' ? 'selected' : ''}>2025-2026</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #008080;">
                            <i class="fas fa-calendar-alt"></i> Semester
                        </label>
                        <select name="semester" id="editGradeSemester" required 
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            <option value="1st Semester" ${grade.semester === '1st Semester' ? 'selected' : ''}>1st Semester</option>
                            <option value="2nd Semester" ${grade.semester === '2nd Semester' ? 'selected' : ''}>2nd Semester</option>
                            <option value="Summer" ${grade.semester === 'Summer' ? 'selected' : ''}>Summer</option>
                        </select>
                    </div>
                    
                    <div style="text-align: right;">
                        <button type="button" onclick="hideEditGradeModal()" 
                                style="background: #ccc; color: #333; padding: 10px 20px; border: none; border-radius: 5px; margin-right: 10px; cursor: pointer;">
                            Cancel
                        </button>
                        <button type="submit" id="submitEditGradeBtn"
                                style="background: #008080; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                            <i class="fas fa-save"></i> Update Grade
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', editModalHTML);
    
    // Add form submit handler
    document.getElementById('editGradeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateGrade(grade.id);
    });
    
    // Show modal
    document.getElementById('editGradeModal').style.display = 'flex';
}

// Function to hide edit grade modal
function hideEditGradeModal() {
    const modal = document.getElementById('editGradeModal');
    if (modal) {
        modal.remove();
    }
}

// Function to update grade
async function updateGrade(gradeId) {
    const form = document.getElementById('editGradeForm');
    const formData = new FormData(form);
    
    console.log('Updating grade ID:', gradeId);
    console.log('Form data:', Object.fromEntries(formData.entries()));
    
    // Show loading
    const submitBtn = document.getElementById('submitEditGradeBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    
    try {
        const response = await fetch(`/grades/${gradeId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('✅ ' + data.message);
            hideEditGradeModal();
            
            // Refresh the grades table
            const currentStudentId = window.currentStudentId;
            const currentStudentName = window.currentStudentName;
            
            if (currentStudentId && currentStudentName) {
                // Close view modal and reopen to refresh
                hideViewGradesModal();
                setTimeout(() => {
                    viewStudentGrades(currentStudentId, currentStudentName);
                }, 500);
            }
        } else {
            alert('❌ Error: ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Error updating grade:', error);
        alert('❌ Error updating grade');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}
        // Auto-refresh time every minute
        document.addEventListener('DOMContentLoaded', function() {
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
            
            updateTime();
            setInterval(updateTime, 60000);
            
            console.log('Dashboard loaded successfully!');
        });

    </script>
</body>
</html>