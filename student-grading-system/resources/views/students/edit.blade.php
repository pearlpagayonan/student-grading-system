<form action="{{ route('students.update', $student->id) }}" method="POST" id="editStudentForm">
    @csrf
    @method('PUT')
    
    <!-- Student Info Card -->
    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
        <div>
            <img src="{{ $student->profile_picture ? asset('storage/' . $student->profile_picture) : asset('images/default-avatar.png') }}" 
                 alt="{{ $student->name }}" 
                 style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid #008080;">
        </div>
        <div>
            <h3 style="margin: 0 0 5px 0; color: #008080; font-size: 18px;">{{ $student->name }}</h3>
            <p style="margin: 0 0 3px 0; color: #666; font-size: 13px;">
                <strong>ID:</strong> <code>{{ $student->student_number }}</code>
            </p>
            <p style="margin: 0; color: #666; font-size: 13px;">
                <strong>Section:</strong> {{ $student->section }} | <strong>Year:</strong> {{ $student->year_level }}
            </p>
        </div>
    </div>
    
    <!-- Success/Error Messages -->
    <div id="editFormErrors" style="display: none; background: #FFEBEE; padding: 12px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #f44336;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <i class="fas fa-exclamation-triangle" style="color: #C62828; font-size: 16px;"></i>
            <strong style="font-size: 14px;">Please fix the following errors:</strong>
        </div>
        <ul id="editErrorList" style="margin: 0; padding-left: 20px; font-size: 13px;"></ul>
    </div>
    
    <!-- Edit Form Content (NO OUTER SCROLLABLE DIV) -->
    <!-- Basic Information -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Full Name *</label>
            <input type="text" name="name" value="{{ $student->name }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;" required>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Student Number</label>
            <input type="text" name="student_number" value="{{ $student->student_number }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Email *</label>
            <input type="email" name="email" value="{{ $student->email }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;" required>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Contact</label>
            <input type="tel" name="contact_number" value="{{ $student->contact_number }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;"
                   placeholder="09XX-XXX-XXXX">
        </div>
    </div>
    
    <!-- Personal Information -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Gender *</label>
            <select name="gender" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;" required>
                <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Birthdate</label>
            <input type="date" name="birthdate" value="{{ $student->birthdate }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
        </div>
    </div>
    
    <!-- Academic Information -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Section *</label>
            <select name="section" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;" required>
                <option value="Section A" {{ $student->section == 'Section A' ? 'selected' : '' }}>Section A</option>
                <option value="Section B" {{ $student->section == 'Section B' ? 'selected' : '' }}>Section B</option>
                <option value="Section C" {{ $student->section == 'Section C' ? 'selected' : '' }}>Section C</option>
                <option value="Section D" {{ $student->section == 'Section D' ? 'selected' : '' }}>Section D</option>
                <option value="Section E" {{ $student->section == 'Section E' ? 'selected' : '' }}>Section E</option>
                <option value="Section F" {{ $student->section == 'Section F' ? 'selected' : '' }}>Section F</option>
            </select>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Year Level *</label>
            <select name="year_level" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;" required>
                <option value="1st Year" {{ $student->year_level == '1st Year' ? 'selected' : '' }}>1st Year</option>
                <option value="2nd Year" {{ $student->year_level == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                <option value="3rd Year" {{ $student->year_level == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                <option value="4th Year" {{ $student->year_level == '4th Year' ? 'selected' : '' }}>4th Year</option>
            </select>
        </div>
    </div>
    
    <!-- Address -->
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Address</label>
        <textarea name="address" rows="2" 
                  style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; resize: vertical;">{{ $student->address }}</textarea>
    </div>
    
    <!-- Guardian Information -->
    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
        <h4 style="color: #008080; margin: 0 0 10px 0; font-size: 15px;">
            <i class="fas fa-users"></i> Guardian Information
        </h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 13px;">Guardian Name</label>
                <input type="text" name="guardian_name" value="{{ $student->guardian_name }}" 
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 13px;">Guardian Contact</label>
                <input type="tel" name="guardian_contact" value="{{ $student->guardian_contact }}" 
                       style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;"
                       placeholder="09XX-XXX-XXXX">
            </div>
        </div>
    </div>
    
    <!-- Academic Performance -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Average Grade</label>
            <input type="number" step="0.01" min="0" max="100" name="average_grade" 
                   value="{{ $student->average_grade }}" 
                   style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #555; font-size: 14px;">Status *</label>
            <select name="status" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;" required>
                <option value="Active" {{ $student->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $student->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Transferred" {{ $student->status == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                <option value="Graduated" {{ $student->status == 'Graduated' ? 'selected' : '' }}>Graduated</option>
            </select>
        </div>
    </div>
    
    <!-- Form Buttons -->
    <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 15px; border-top: 1px solid #eee;">
        <button type="button" onclick="closeEditModal()" 
                style="padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fas fa-times"></i> Cancel
        </button>
        <button type="submit" id="updateStudentBtn"
                style="padding: 8px 15px; background: #FFA500; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fas fa-save"></i> Update
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format contact numbers as they're typed
        const contactInputs = document.querySelectorAll('input[type="tel"]');
        
        contactInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.substring(0, 11);
                
                if (value.length > 7) {
                    value = value.replace(/(\d{4})(\d{3})(\d{0,4})/, '$1-$2-$3');
                } else if (value.length > 4) {
                    value = value.replace(/(\d{4})(\d{0,3})/, '$1-$2');
                }
                
                e.target.value = value;
            });
        });
        
        // Set birthdate max to today
        const today = new Date().toISOString().split('T')[0];
        const birthdateInput = document.querySelector('input[name="birthdate"]');
        if (birthdateInput) {
            birthdateInput.setAttribute('max', today);
        }
        
        // Form submission handler
        const form = document.getElementById('editStudentForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('updateStudentBtn');
                const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
                
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                    submitBtn.disabled = true;
                }
                
                // Hide previous errors
                const errorDiv = document.getElementById('editFormErrors');
                const errorList = document.getElementById('editErrorList');
                if (errorDiv) errorDiv.style.display = 'none';
                if (errorList) errorList.innerHTML = '';
                
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success and close modal
                        if (typeof showSuccessNotification === 'function') {
                            showSuccessNotification(data.message || 'Student updated successfully!');
                        }
                        
                        // Close modal after 1 second
                        setTimeout(() => {
                            if (typeof closeEditModal === 'function') {
                                closeEditModal();
                            }
                            
                            // Reload page after another 0.5 seconds
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        }, 1000);
                    } else if (data.errors) {
                        // Display validation errors
                        if (errorDiv && errorList) {
                            for (const field in data.errors) {
                                data.errors[field].forEach(msg => {
                                    errorList.innerHTML += `<li>${msg}</li>`;
                                });
                            }
                            
                            errorDiv.style.display = 'block';
                            
                            // Scroll to errors
                            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                })
                .catch(error => {
                    console.error('Update error:', error);
                    alert('Error updating student. Please try again.');
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    }
                });
            });
        }
    });
</script>