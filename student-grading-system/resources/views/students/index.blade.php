@extends('layouts.app')

@section('title', 'Manage Students')

@section('content')
    <!-- Page Header -->
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
        <!-- Left: Title -->
        <h1 style="color: #FFA500; margin: 0;"><i class="fas fa-users"></i> Manage Students</h1>
        
        <!-- Center: Search Bar -->
        <div style="flex: 1; display: flex; justify-content: center; max-width: 500px;">
            <form action="{{ route('students.index') }}" method="GET" style="display: flex; width: 100%; max-width: 400px;">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by name, student number, section, email..."
                    value="{{ request('search') }}"
                    style="flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px 0 0 5px; font-size: 14px; outline: none;"
                >
                <button type="submit" style="background: #008080; color: white; border: none; border-radius: 0 5px 5px 0; padding: 10px 20px; cursor: pointer;">
                    <i class="fas fa-search"></i> Search
                </button>
                
                <!-- Clear search button if search is active -->
                @if(request()->has('search') && !empty(request('search')))
                <a href="{{ route('students.index') }}" 
                   style="background: #f44336; color: white; border: none; border-radius: 0; padding: 10px 15px; text-decoration: none; display: flex; align-items: center;"
                   title="Clear search">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>
        </div>
        
<!-- Right: Add Student Button - 100% WORKING -->
        <!-- Right: Add Student Button -->
        <div>
            <a href="{{ route('students.create') }}" class="btn-orange" style="background: #FFA500; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; display: inline-block; font-weight: bold;">
                <i class="fas fa-plus"></i> Add Student
            </a>
        </div>
    </div>
    <!-- Search Results Banner -->
    @if(request()->has('search') && !empty(request('search')))
    <div style="background: #E8F5E9; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #4CAF50;">
        <i class="fas fa-search" style="color: #4CAF50; margin-right: 10px;"></i>
        <strong>Search Results:</strong> Found {{ $students->total() }} student(s) for "<strong>{{ request('search') }}</strong>"
        <a href="{{ route('students.index') }}" style="float: right; color: #008080; text-decoration: none;">
            <i class="fas fa-times"></i> Clear search
        </a>
    </div>
    @endif
    
    <!-- Students Table -->
    <div class="table" style="width: 100%; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Profile</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Name</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Student ID</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Section</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Year Level</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Gender</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Average Grade</th>
                    <th style="background: #008080; color: white; padding: 15px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($students) && $students->count() > 0)
                    @foreach($students as $student)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">
                            <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $student->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td style="padding: 15px;"><strong>{{ $student->name }}</strong></td>
                        <td style="padding: 15px;"><code>{{ $student->student_number }}</code></td>
                        <td style="padding: 15px;">{{ $student->section }}</td>
                        <td style="padding: 15px;">{{ $student->year_level }}</td>
                        <td style="padding: 15px;">
                            @php
                                $badgeClass = 'badge-other';
                                if($student->gender == 'male') $badgeClass = 'badge-male';
                                elseif($student->gender == 'female') $badgeClass = 'badge-female';
                            @endphp
                            <span class="badge {{ $badgeClass }}" style="padding: 5px 10px; border-radius: 20px; font-size: 12px; display: inline-block; 
                                {{ $badgeClass == 'badge-male' ? 'background: #E3F2FD; color: #1565C0;' : '' }}
                                {{ $badgeClass == 'badge-female' ? 'background: #FCE4EC; color: #C2185B;' : '' }}
                                {{ $badgeClass == 'badge-other' ? 'background: #E8F5E9; color: #2E7D32;' : '' }}">
                                {{ ucfirst($student->gender) }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            @php
                                $average = $student->average_grade ?? 0;
                                $color = '#FF9800';
                                if($average >= 90) $color = '#4CAF50';
                                elseif($average >= 80) $color = '#2196F3';
                            @endphp
                            <span style="font-weight: bold; color: {{ $color }}">
                                {{ number_format($average, 2) }}
                            </span>
                        </td>
                        <!-- Actions column - REMOVE VIEW BUTTON -->
<td style="padding: 15px;">
    <div style="display: flex; gap: 8px; flex-wrap: nowrap;">
        <!-- Edit Button (Modal Trigger) -->
        <button type="button" onclick="openEditModal({{ $student->id }})"
                style="padding: 6px 12px; border-radius: 4px; background: #FFA500; color: white; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 13px; white-space: nowrap;">
            <i class="fas fa-edit"></i> Edit
        </button>
        
        <!-- Archive Button -->
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" 
              style="display: inline; margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Move this student to archive?')"
                    style="padding: 6px 12px; border-radius: 4px; background: #f44336; color: white; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 13px; white-space: nowrap;">
                <i class="fas fa-trash"></i> Archive
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                            @if(request()->has('search'))
                                <i class="fas fa-search" style="font-size: 50px; margin-bottom: 15px; color: #ccc;"></i>
                                <h3 style="margin-bottom: 10px;">No Students Found</h3>
                                <p>No students match "{{ request('search') }}".</p>
                            @else
                                <i class="fas fa-users-slash" style="font-size: 50px; margin-bottom: 15px; color: #ccc;"></i>
                                <h3 style="margin-bottom: 10px;">No Students Found</h3>
                                <p>Click "Add Student" to add your first student record.</p>
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(isset($students) && method_exists($students, 'hasPages') && $students->hasPages())
    <div style="margin-top: 20px; text-align: center;">
        {{ $students->links() }}
    </div>
    @endif
    
    <!-- Statistics Summary -->
    <div style="display: flex; justify-content: space-between; margin-top: 30px; gap: 15px;">
        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #008080; margin-bottom: 10px;"><i class="fas fa-users"></i> Total Students</h3>
            <p style="font-size: 32px; font-weight: bold; color: #FFA500;">{{ $students->total() ?? 0 }}</p>
        </div>
        
        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #008080; margin-bottom: 10px;"><i class="fas fa-venus"></i> Female</h3>
            <p style="font-size: 32px; font-weight: bold; color: #C2185B;">
                {{ $students->where('gender', 'Female')->count() }}
            </p>
        </div>
        
        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #008080; margin-bottom: 10px;"><i class="fas fa-mars"></i> Male</h3>
            <p style="font-size: 32px; font-weight: bold; color: #1565C0;">
                {{ $students->where('gender', 'Male')->count() }}
            </p>
        </div>
        
        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #008080; margin-bottom: 10px;"><i class="fas fa-star"></i> Average GPA</h3>
            <p style="font-size: 32px; font-weight: bold; color: #4CAF50;">
                @php
                    $averageGrade = $students->avg('average_grade');
                @endphp
                {{ number_format($averageGrade ?? 0, 2) }}
            </p>
        </div>
    </div>
    <!-- EDIT STUDENT MODAL -->
<div id="editStudentModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: white; width: 90%; max-width: 700px; max-height: 90vh; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3); display: flex; flex-direction: column;">
        <!-- Modal Header -->
        <div style="flex-shrink: 0; background: linear-gradient(135deg, #FFA500, #FF8C00); color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: 22px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user-edit"></i> Edit Student
            </h2>
            <button onclick="closeEditModal()" style="background: none; border: none; color: white; font-size: 28px; cursor: pointer; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;">
                &times;
            </button>
        </div>
        
        <!-- Modal Body (Scrollable) -->
        <div id="editModalContent" style="flex: 1; overflow-y: auto; padding: 30px;">
            <!-- Loading Spinner -->
            <div id="modalLoading" style="text-align: center; padding: 50px;">
                <div style="border: 4px solid #f3f3f3; border-top: 4px solid #FFA500; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                <p style="color: #666; font-size: 16px;">Loading student information...</p>
            </div>
            
            <!-- Form will be loaded here -->
            <div id="editFormContainer" style="display: none;"></div>
        </div>
    </div>
</div>

<!-- SUCCESS NOTIFICATION -->
<div id="successNotification" style="display: none; position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 10000; align-items: center; gap: 12px; animation: slideInRight 0.3s ease;">
    <i class="fas fa-check-circle" style="font-size: 22px;"></i>
    <span id="successMessage">Student updated successfully!</span>
</div>
@endsection

@section('scripts')
<script>
    // EDIT MODAL FUNCTIONS
function openEditModal(studentId) {
    console.log('Opening edit modal for student:', studentId);
    
    // Show modal with loading state
    document.getElementById('editStudentModal').style.display = 'flex';
    document.getElementById('modalLoading').style.display = 'block';
    document.getElementById('editFormContainer').style.display = 'none';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
    
    // Fetch student data
    fetch(`/students/${studentId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            // Hide loading, show form
            document.getElementById('modalLoading').style.display = 'none';
            document.getElementById('editFormContainer').style.display = 'block';
            document.getElementById('editFormContainer').innerHTML = html;
            
            // Add form submission handler
            const form = document.querySelector('#editFormContainer form');
            if (form) {
                setupEditForm(form, studentId);
            }
        })
        .catch(error => {
            console.error('Error loading edit form:', error);
            document.getElementById('modalLoading').innerHTML = `
                <div style="text-align: center; padding: 40px; color: #f44336;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 20px;"></i>
                    <h3 style="margin-bottom: 10px;">Error Loading Form</h3>
                    <p>${error.message}</p>
                    <button onclick="openEditModal(${studentId})" class="btn-primary" style="margin-top: 20px;">
                        <i class="fas fa-redo"></i> Try Again
                    </button>
                </div>
            `;
        });
}

function setupEditForm(form, studentId) {
    // Remove AJAX and use traditional form submission
    form.addEventListener('submit', function(e) {
        // Just let the form submit normally
        // No AJAX, no loading state manipulation
        
        // Optional: Add a small delay for UX
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
        }
        
        // Form will submit normally, page will reload
        return true;
    });
}

function showFormErrors(form, errorData) {
    // Remove existing error messages
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    form.querySelectorAll('.error-border').forEach(el => el.classList.remove('error-border'));
    
    if (errorData.errors) {
        // Add new error messages
        for (const field in errorData.errors) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('error-border');
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.style.color = '#f44336';
                errorDiv.style.fontSize = '12px';
                errorDiv.style.marginTop = '5px';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${errorData.errors[field][0]}`;
                
                input.parentNode.appendChild(errorDiv);
            }
        }
        
        // Scroll to first error
        const firstError = form.querySelector('.error-border');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

function closeEditModal() {
    document.getElementById('editStudentModal').style.display = 'none';
    document.body.style.overflow = 'auto'; // Re-enable scrolling
}

function showSuccessNotification(message) {
    const notification = document.getElementById('successNotification');
    const messageSpan = document.getElementById('successMessage');
    
    messageSpan.textContent = message;
    notification.style.display = 'flex';
    
    // Auto-hide after 3 seconds
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}

// Close modal when clicking outside
document.getElementById('editStudentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Also add this to fix the Add Student button
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('addStudentBtn');
    if (addBtn) {
        const newBtn = addBtn.cloneNode(true);
        addBtn.parentNode.replaceChild(newBtn, addBtn);
        
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = this.href;
            return false;
        });
    }
});
    // Students page specific scripts
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        
        if (searchInput) {
            // Focus on search input on page load
            searchInput.focus();
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + F to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }
            });
        }
        
        // Add loading indicator on form submit
        const searchForm = document.querySelector('form[action="{{ route("students.index") }}"]');
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
                    submitBtn.disabled = true;
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('addStudentBtn');
    if (addBtn) {
        // Remove all existing click handlers
        const newBtn = addBtn.cloneNode(true);
        addBtn.parentNode.replaceChild(newBtn, addBtn);
        
        // Add new clean click handler
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Navigating to create form...');
            window.location.href = this.href;
            return false;
        });
    }
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
@endsection