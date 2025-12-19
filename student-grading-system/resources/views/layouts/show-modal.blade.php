<div class="modal-header flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Student Profile</h2>
    <button class="modal-close text-gray-500 hover:text-gray-700">
        <i class="fas fa-times text-xl"></i>
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Left Column - Profile Info -->
    <div class="md:col-span-1">
        <div class="text-center mb-6">
            <img src="{{ $student->profile_picture ? asset('storage/profile-pictures/' . basename($student->profile_picture)) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&color=008080&background=E0F2F1&size=200' }}" 
                 alt="{{ $student->name }}" 
                 class="profile-pic mx-auto mb-4">
            <h3 class="text-xl font-bold text-gray-800">{{ $student->name }}</h3>
            <p class="text-gray-600">{{ $student->student_id }}</p>
        </div>
        
        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded">
                <h4 class="font-bold text-gray-700 mb-2">Personal Information</h4>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm text-gray-500">Email:</span>
                        <p>{{ $student->email }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Contact:</span>
                        <p>{{ $student->contact_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Gender:</span>
                        <p class="capitalize">{{ $student->gender }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-gray-50 rounded">
                <h4 class="font-bold text-gray-700 mb-2">Academic Information</h4>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm text-gray-500">Year Level:</span>
                        <p>{{ $student->year_level }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Section:</span>
                        <p>{{ $student->section }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Section Ranking:</span>
                        <p class="font-bold text-orange-600">#{{ $sectionRanking ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column - Grades -->
    <div class="md:col-span-2">
        <div class="bg-teal-50 border-l-4 border-teal-500 p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-line text-teal-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-bold text-teal-800">Overall Average</h3>
                    <p class="text-3xl font-bold text-teal-600">{{ number_format($averageGrade, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Units</th>
                        <th>School Year</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grades as $grade)
                    <tr>
                        <td>{{ $grade->subject }}</td>
                        <td class="font-bold {{ $grade->grade >= 90 ? 'text-green-600' : ($grade->grade >= 80 ? 'text-blue-600' : 'text-orange-600') }}">
                            {{ number_format($grade->grade, 2) }}
                        </td>
                        <td>{{ $grade->units }}</td>
                        <td>{{ $grade->school_year }}</td>
                        <td>{{ $grade->semester }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            No grades recorded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Add Grade Form -->
        <div class="mt-6 p-4 border border-gray-200 rounded">
            <h4 class="font-bold text-gray-700 mb-4">Add New Grade</h4>
            <form id="addGradeForm" data-student-id="{{ $student->id }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="subject" placeholder="Subject" required 
                           class="p-2 border border-gray-300 rounded">
                    <input type="number" name="grade" placeholder="Grade (0-100)" min="0" max="100" step="0.01" required
                           class="p-2 border border-gray-300 rounded">
                    <input type="number" name="units" placeholder="Units" min="1" max="5" required
                           class="p-2 border border-gray-300 rounded">
                    <input type="text" name="school_year" placeholder="School Year (e.g., 2023-2024)" required
                           class="p-2 border border-gray-300 rounded">
                    <select name="semester" class="p-2 border border-gray-300 rounded">
                        <option value="1st Semester">1st Semester</option>
                        <option value="2nd Semester">2nd Semester</option>
                        <option value="Summer">Summer</option>
                    </select>
                    <button type="submit" class="btn-teal">
                        <i class="fas fa-plus mr-2"></i> Add Grade
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add grade via AJAX
    document.getElementById('addGradeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const studentId = this.getAttribute('data-student-id');
        
        fetch('/grades', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to show new grade
            } else {
                alert('Error adding grade: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding grade');
        });
    });
</script>