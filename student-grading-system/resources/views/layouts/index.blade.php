@extends('layouts.app')

@section('title', 'Manage Students')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Manage Students</h1>
        <a href="{{ route('students.create') }}" class="btn-orange flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Student
        </a>
    </div>
    
    <!-- Search and Filters -->
    <div class="card">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1">
                <input type="text" 
                       id="searchStudents" 
                       placeholder="Search by name, student ID, or section..." 
                       class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="flex space-x-4">
                <select id="filterSection" class="p-2 border border-gray-300 rounded">
                    <option value="">All Sections</option>
                    @foreach($sections as $section)
                        <option value="{{ $section }}">{{ $section }}</option>
                    @endforeach
                </select>
                <select id="filterYearLevel" class="p-2 border border-gray-300 rounded">
                    <option value="">All Year Levels</option>
                    @foreach(['1st Year', '2nd Year', '3rd Year', '4th Year'] as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <!-- Students Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="table" id="studentsTable">
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
                    @foreach($students as $student)
                    <tr data-student-id="{{ $student->id }}" 
                        data-section="{{ $student->section }}"
                        data-year-level="{{ $student->year_level }}">
                        <td>
                            <img src="{{ $student->profile_picture ? asset('storage/profile-pictures/' . basename($student->profile_picture)) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&color=008080&background=E0F2F1' }}" 
                                 alt="{{ $student->name }}" 
                                 class="w-10 h-10 rounded-full cursor-pointer view-profile"
                                 data-id="{{ $student->id }}">
                        </td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->section }}</td>
                        <td>{{ $student->year_level }}</td>
                        <td>
                            <span class="px-2 py-1 rounded-full text-xs {{ $student->gender == 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ ucfirst($student->gender) }}
                            </span>
                        </td>
                        <td class="font-bold {{ $student->average_grade >= 90 ? 'text-green-600' : ($student->average_grade >= 80 ? 'text-blue-600' : 'text-orange-600') }}">
                            {{ number_format($student->average_grade, 2) }}
                        </td>
                        <td>
                            <div class="flex space-x-2">
                                <button class="view-profile text-teal-600 hover:text-teal-800" 
                                        data-id="{{ $student->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('students.edit', $student) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Archive this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div id="profileModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <!-- Modal content will be loaded here via AJAX -->
    </div>
</div>

@push('scripts')
<script>
    // Student profile modal
    document.querySelectorAll('.view-profile').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-id');
            loadStudentProfile(studentId);
        });
    });
    
    function loadStudentProfile(studentId) {
        fetch(`/students/${studentId}/profile`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('profileModal').style.display = 'flex';
                document.querySelector('.modal-content').innerHTML = html;
                
                // Add close button functionality
                const closeBtn = document.querySelector('.modal-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        document.getElementById('profileModal').style.display = 'none';
                    });
                }
                
                // Close modal when clicking outside
                document.getElementById('profileModal').addEventListener('click', (e) => {
                    if (e.target.id === 'profileModal') {
                        document.getElementById('profileModal').style.display = 'none';
                    }
                });
            });
    }
    
    // Search functionality
    document.getElementById('searchStudents').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#studentsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    
    // Filter functionality
    document.getElementById('filterSection').addEventListener('change', filterStudents);
    document.getElementById('filterYearLevel').addEventListener('change', filterStudents);
    
    function filterStudents() {
        const sectionFilter = document.getElementById('filterSection').value;
        const yearFilter = document.getElementById('filterYearLevel').value;
        const rows = document.querySelectorAll('#studentsTable tbody tr');
        
        rows.forEach(row => {
            const section = row.getAttribute('data-section');
            const yearLevel = row.getAttribute('data-year-level');
            
            const showSection = !sectionFilter || section === sectionFilter;
            const showYear = !yearFilter || yearLevel === yearFilter;
            
            row.style.display = (showSection && showYear) ? '' : 'none';
        });
    }
</script>
@endpush
@endsection