{{-- resources/views/students/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-plus"></i> Add New Student</h1>
        <a href="{{ route('students.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
    </div>
    
    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <div class="alert-content">
            <strong>Success!</strong> {{ session('success') }}
            @if(session('temporary_password'))
            <div class="temporary-password">
                Temporary Password: <code>{{ session('temporary_password') }}</code>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- Form Container -->
    <div class="form-wrapper">
        <h2 class="form-title"><i class="fas fa-user-graduate"></i> Student Information</h2>
        
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" id="addStudentForm">
            @csrf
            
            <!-- USER ACCOUNT SECTION -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-user-circle"></i> Account Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="required">Full Name</label>
                        <input type="text" name="name" id="name" required 
                               value="{{ old('name') }}" placeholder="Enter student's full name">
                        <div class="form-help">Required field</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="required">Email Address</label>
                        <input type="email" name="email" id="email" required 
                               value="{{ old('email') }}" placeholder="student@school.edu.ph">
                        <div class="form-help">Will be used for login</div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                               placeholder="Leave blank to auto-generate">
                        <div class="form-help">Minimum 8 characters</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               placeholder="Confirm password">
                    </div>
                </div>
            </div>
            
            <!-- STUDENT DETAILS SECTION -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-id-card"></i> Student Details</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="student_number">Student Number</label>
                        <input type="text" name="student_number" id="student_number"
                               value="{{ old('student_number') }}" placeholder="e.g., 2023-001">
                        <div class="form-help"><i class="fas fa-info-circle"></i> Auto-generate if blank</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <div class="file-upload">
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                            <label for="profile_picture" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose file</span>
                            </label>
                        </div>
                        <div class="form-help">JPG, PNG, GIF (Max 2MB)</div>
                        <div id="profile-preview"></div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" name="contact_number" id="contact_number"
                               value="{{ old('contact_number') }}" placeholder="09XX-XXX-XXXX">
                    </div>
                    
                    <div class="form-group">
                        <label for="gender" class="required">Gender</label>
                        <select name="gender" id="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- ACADEMIC INFORMATION -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Academic Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="section" class="required">Section</label>
                        <select name="section" id="section" required>
                            <option value="">Select Section</option>
                            <option value="Section A" {{ old('section') == 'Section A' ? 'selected' : '' }}>Section A</option>
                            <option value="Section B" {{ old('section') == 'Section B' ? 'selected' : '' }}>Section B</option>
                            <option value="Section C" {{ old('section') == 'Section C' ? 'selected' : '' }}>Section C</option>
                            <option value="Section D" {{ old('section') == 'Section D' ? 'selected' : '' }}>Section D</option>
                            <option value="Section E" {{ old('section') == 'Section E' ? 'selected' : '' }}>Section E</option>
                            <option value="Section F" {{ old('section') == 'Section F' ? 'selected' : '' }}>Section F</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="year_level" class="required">Year Level</label>
                        <select name="year_level" id="year_level" required>
                            <option value="">Select Year Level</option>
                            <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                            <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="average_grade">Average Grade</label>
                        <div class="input-with-icon">
                            <input type="number" step="0.01" min="0" max="100" name="average_grade" id="average_grade" 
                                   value="{{ old('average_grade', 0) }}" placeholder="0.00">
                            <span class="input-icon">%</span>
                        </div>
                        <div class="form-help">0.00 if not available</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="required">Status</label>
                        <select name="status" id="status" required>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="Transferred" {{ old('status') == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                            <option value="Graduated" {{ old('status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- PERSONAL INFORMATION -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-user"></i> Personal Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" rows="3" placeholder="Enter complete address">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- GUARDIAN INFORMATION -->
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-users"></i> Guardian Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="guardian_name">Guardian Name</label>
                        <input type="text" name="guardian_name" id="guardian_name"
                               value="{{ old('guardian_name') }}" placeholder="Guardian's full name">
                    </div>
                    
                    <div class="form-group">
                        <label for="guardian_contact">Guardian Contact</label>
                        <input type="tel" name="guardian_contact" id="guardian_contact"
                               value="{{ old('guardian_contact') }}" placeholder="09XX-XXX-XXXX">
                    </div>
                </div>
            </div>
            
           
            <!-- FORM BUTTONS -->
            <div class="form-actions">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
/* ===== MAIN CONTAINER ===== */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* ===== PAGE HEADER ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    border-left: 5px solid #008080;
}

.page-header h1 {
    color: #008080;
    font-size: 28px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-header h1 i {
    color: #FFA500;
    font-size: 32px;
}

.btn-back {
    background: #008080;
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    border: 2px solid #008080;
}



/* ===== ALERT MESSAGES ===== */
.alert {
    background: #E8F5E9;
    color: #2E7D32;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    border-left: 5px solid #4CAF50;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    animation: slideIn 0.5s ease;
}

.alert i {
    font-size: 24px;
    margin-top: 2px;
}

.alert-content {
    flex: 1;
}

.alert strong {
    font-size: 16px;
}

.temporary-password {
    margin-top: 10px;
    padding: 10px;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 6px;
    border: 1px dashed #4CAF50;
}

.temporary-password code {
    background: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    color: #008080;
}

/* ===== FORM WRAPPER ===== */
.form-wrapper {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.form-title {
    color: #008080;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 35px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-title i {
    color: #FFA500;
}

/* ===== FORM SECTIONS ===== */
.form-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #f0f0f0;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    color: #008080;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #FFA500;
    font-size: 18px;
}

/* ===== FORM ROWS & GROUPS ===== */
.form-row {
    display: flex;
    gap: 25px;
    margin-bottom: 25px;
}

.form-group {
    flex: 1;
    position: relative;
}

.form-group.full-width {
    flex: 2;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #444;
    font-size: 15px;
}

.form-group label.required::after {
    content: " *";
    color: #f44336;
}

/* ===== FORM INPUTS ===== */
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: white;
    color: #333;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #008080;
    box-shadow: 0 0 0 3px rgba(0, 128, 128, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

/* ===== SELECT STYLING ===== */
.form-group select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23008080' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 14px;
    padding-right: 45px;
}

/* ===== FILE UPLOAD ===== */
.file-upload {
    position: relative;
    overflow: hidden;
}

.file-upload input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px;
    background: #f8f9fa;
    border: 2px dashed #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #666;
    font-weight: 500;
}

.file-label:hover {
    background: #e9ecef;
    border-color: #008080;
    color: #008080;
}

.file-label i {
    font-size: 18px;
}

/* ===== INPUT WITH ICON ===== */
.input-with-icon {
    position: relative;
}

.input-with-icon input {
    padding-right: 45px;
}

.input-icon {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    font-weight: 600;
}

/* ===== FORM HELP TEXT ===== */
.form-help {
    font-size: 13px;
    color: #666;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.form-help i {
    font-size: 12px;
}

/* ===== FORM ACTIONS ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.btn {
    padding: 14px 30px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-primary {
    background: #FFA500;
    color: white;
    border-color: #FFA500;
}

.btn-primary:hover {
    background: #e69500;
    border-color: #e69500;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background: #5a6268;
    border-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
}

/* ===== PROFILE PREVIEW ===== */
#profile-preview {
    margin-top: 15px;
    text-align: center;
}

#profile-preview img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #008080;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* ===== ANIMATIONS ===== */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }
    
    .page-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
        padding: 20px;
    }
    
    .page-header h1 {
        font-size: 24px;
    }
    
    .form-wrapper {
        padding: 25px;
    }
    
    .form-row {
        flex-direction: column;
        gap: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* ===== VALIDATION STATES ===== */
input:invalid,
select:invalid,
textarea:invalid {
    border-color: #ffcdd2;
}

input:valid:not(:placeholder-shown),
select:valid,
textarea:valid:not(:placeholder-shown) {
    border-color: #c8e6c9;
}
/* Modal Animations */
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Modal Scrollbar Styling */
.modal-content::-webkit-scrollbar {
    width: 8px;
}

.modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.modal-content::-webkit-scrollbar-thumb {
    background: #FFA500;
    border-radius: 4px;
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background: #e69500;
}

/* Form inside modal */
.modal-form .form-group {
    margin-bottom: 20px;
}

.modal-form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #444;
    font-size: 14px;
}

.modal-form input,
.modal-form select,
.modal-form textarea {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.modal-form input:focus,
.modal-form select:focus,
.modal-form textarea:focus {
    outline: none;
    border-color: #FFA500;
}

.modal-form .form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.modal-form .form-col {
    flex: 1;
}

/* Modal form buttons */
.modal-form .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.modal-form .btn {
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.modal-form .btn-primary {
    background: #FFA500;
    color: white;
}

.modal-form .btn-primary:hover {
    background: #e69500;
    transform: translateY(-2px);
}

.modal-form .btn-secondary {
    background: #6c757d;
    color: white;
}

.modal-form .btn-secondary:hover {
    background: #5a6268;
}
</style>
@endsection

@section('scripts')
<script>
    
document.addEventListener('DOMContentLoaded', function() {
    // Set birthdate max to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('birthdate').setAttribute('max', today);
    
    // Auto-generate student number if empty
    const studentNumberInput = document.getElementById('student_number');
    if (!studentNumberInput.value) {
        const year = new Date().getFullYear();
        const randomNum = Math.floor(Math.random() * 9999) + 1;
        const studentId = `${year}-${randomNum.toString().padStart(4, '0')}`;
        studentNumberInput.value = studentId;
    }
    
    // Auto-generate email from name
    document.getElementById('name').addEventListener('blur', function() {
        const nameInput = this.value.trim();
        const emailInput = document.getElementById('email');
        
        if (nameInput && !emailInput.value) {
            const nameParts = nameInput.toLowerCase().split(' ');
            if (nameParts.length >= 2) {
                const firstName = nameParts[0].replace(/[^a-z]/g, '');
                const lastName = nameParts[nameParts.length - 1].replace(/[^a-z]/g, '');
                const email = `${firstName}.${lastName}@student.edu.ph`;
                emailInput.value = email;
            }
        }
    });
    
    // Profile picture preview
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            let preview = document.getElementById('profile-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'profile-preview';
                preview.className = 'preview-container';
                e.target.parentNode.appendChild(preview);
            }
            
            preview.innerHTML = `
                <div class="preview-image">
                    <img src="${e.target.result}" alt="Preview">
                    <div class="preview-text">Image Preview</div>
                </div>
            `;
        };
        
        if (file) {
            reader.readAsDataURL(file);
        }
    });
    
    // Format contact numbers
    function formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 11) value = value.substring(0, 11);
        
        if (value.length > 7) {
            value = value.replace(/(\d{4})(\d{3})(\d{0,4})/, '$1-$2-$3');
        } else if (value.length > 4) {
            value = value.replace(/(\d{4})(\d{0,3})/, '$1-$2');
        }
        
        input.value = value;
    }
    
    document.getElementById('contact_number').addEventListener('input', function(e) {
        formatPhoneNumber(this);
    });
    
    document.getElementById('guardian_contact').addEventListener('input', function(e) {
        formatPhoneNumber(this);
    });
    
    // Auto-suggest guardian name
    document.getElementById('name').addEventListener('blur', function() {
        const guardianInput = document.getElementById('guardian_name');
        if (!guardianInput.value) {
            const nameParts = this.value.trim().split(' ');
            if (nameParts.length >= 2) {
                const lastName = nameParts[nameParts.length - 1];
                guardianInput.value = `Mr./Mrs. ${lastName}`;
            }
        }
    });
    
    // Auto-suggest sections based on year level
    // I-replace ang existing na year_level change listener ng ganito:

document.getElementById('year_level').addEventListener('change', function() {
    const sectionSelect = document.getElementById('section');
    const yearLevel = this.value;
    
    // Clear current options except first
    while (sectionSelect.options.length > 1) {
        sectionSelect.remove(1);
    }
    
    if (yearLevel) {
        const sections = {
            '1st Year': ['1A', '1B', '1C', '1D', '1E', '1F'],
            '2nd Year': ['2A', '2B', '2C', '2D', '2E', '2F'],
            '3rd Year': ['3A', '3B', '3C', '3D', '3E', '3F'],
            '4th Year': ['4A', '4B', '4C', '4D', '4E', '4F']
        };
        
        if (sections[yearLevel]) {
            sections[yearLevel].forEach(section => {
                const option = new Option(`Section ${section}`, `Section ${section}`);
                sectionSelect.add(option);
            });
        }
    }
});
});
</script>
@endsection