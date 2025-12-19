<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        * { font-family: 'Tahoma', sans-serif; }
        body { margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { color: #FFA500; }
        .btn-orange { background: #FFA500; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; }
        .table { width: 100%; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table th { background: #008080; color: white; padding: 15px; text-align: left; }
        .table td { padding: 15px; border-bottom: 1px solid #eee; }
        .table tr:hover { background: #FFF4E0; }
        .profile-pic { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; }
        .badge-male { background: #E3F2FD; color: #1565C0; }
        .badge-female { background: #FCE4EC; color: #C2185B; }
        .badge-other { background: #E8F5E9; color: #2E7D32; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👥 Manage Students</h1>
            <a href="{{ route('students.create') }}" class="btn-orange">➕ Add Student</a>
        </div>
        
        <div class="table">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Section</th>
                        <th>Year Level</th>
                        <th>Gender</th>
                        <th>Average Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($students->count() > 0)
                        @foreach($students as $student)
                        <tr>
                            <td>
                                <!-- Fixed: Check if attribute exists -->
                                <img src="{{ $student->full_profile_picture ?? asset('images/default-avatar.png') }}" 
                                     alt="{{ $student->name }}" 
                                     class="profile-pic">
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->section }}</td>
                            <td>{{ $student->year_level }}</td>
                            <td>
                                @php
                                    $genderClass = 'badge-other';
                                    if($student->gender == 'male') $genderClass = 'badge-male';
                                    elseif($student->gender == 'female') $genderClass = 'badge-female';
                                @endphp
                                <span class="badge {{ $genderClass }}">
                                    {{ ucfirst($student->gender) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $average = $student->average_grade ?? 0;
                                    $color = '#FF9800'; // default orange
                                    if($average >= 90) $color = '#4CAF50';
                                    elseif($average >= 80) $color = '#2196F3';
                                @endphp
                                <span style="font-weight: bold; color: {{ $color }}">
                                    {{ number_format($average, 2) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('students.edit', $student->id) }}" 
                                   style="background: #FFA500; color: white; border: none; padding: 5px 10px; border-radius: 3px; margin-right: 5px; text-decoration: none; display: inline-block;">
                                   Edit
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 3px;" 
                                            onclick="return confirm('Move student to archive?')">
                                        Archive
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                                No students found. Click "Add Student" to add your first student.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if($students->hasPages())
        <div style="margin-top: 20px; text-align: center;">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</body>
</html>