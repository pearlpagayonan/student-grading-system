@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Picture -->
        <div class="md:col-span-1">
            <div class="card text-center">
                <div class="relative inline-block">
                    <img id="profileImage" 
                         src="{{ Auth::user()->profile_picture ? asset('storage/profile-pictures/' . basename(Auth::user()->profile_picture)) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=008080&background=E0F2F1&size=200' }}" 
                         alt="Profile Picture" 
                         class="w-40 h-40 rounded-full mx-auto mb-4 border-4 border-teal-100">
                    
                    <label for="profilePictureUpload" class="cursor-pointer">
                        <div class="absolute bottom-2 right-2 bg-orange-500 text-white p-2 rounded-full hover:bg-orange-600 transition">
                            <i class="fas fa-camera"></i>
                        </div>
                        <input type="file" 
                               id="profilePictureUpload" 
                               accept="image/*" 
                               class="hidden"
                               onchange="uploadProfilePicture(this)">
                    </label>
                </div>
                
                <h3 class="text-lg font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                <p class="text-gray-600">{{ Auth::user()->student_id }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ Auth::user()->section }}</p>
            </div>
            
            <!-- View-only Info -->
            <div class="card mt-6">
                <h4 class="font-bold text-gray-700 mb-4">Academic Information</h4>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-500">Full Name:</span>
                        <p class="font-medium">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Student ID:</span>
                        <p class="font-medium">{{ Auth::user()->student_id }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Year Level:</span>
                        <p class="font-medium">{{ Auth::user()->year_level }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Section:</span>
                        <p class="font-medium">{{ Auth::user()->section }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Editable Information -->
        <div class="md:col-span-2">
            <div class="card">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address *
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email', Auth::user()->email) }}" 
                                           required
                                           class="w-full p-2 border border-gray-300 rounded focus:border-teal-500 focus:ring focus:ring-teal-200">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Contact Number
                                    </label>
                                    <input type="tel" 
                                           name="contact_number" 
                                           value="{{ old('contact_number', Auth::user()->contact_number) }}"
                                           class="w-full p-2 border border-gray-300 rounded focus:border-teal-500 focus:ring focus:ring-teal-200">
                                    @error('contact_number')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Change Password -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Change Password</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Password
                                    </label>
                                    <input type="password" 
                                           name="current_password"
                                           class="w-full p-2 border border-gray-300 rounded">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            New Password
                                        </label>
                                        <input type="password" 
                                               name="password"
                                               class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm New Password
                                        </label>
                                        <input type="password" 
                                               name="password_confirmation"
                                               class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="btn-orange px-6 py-2">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Grades Summary -->
            @if(Auth::user()->isStudent())
            <div class="card mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Grades Summary</h3>
                    <a href="{{ route('grades.mygrades') }}" class="text-teal-600 hover:text-teal-800">
                        View All Grades <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded text-center">
                        <p class="text-sm text-gray-500">Average Grade</p>
                        <p class="text-2xl font-bold text-teal-600">
                            {{ number_format(Auth::user()->average_grade, 2) }}
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded text-center">
                        <p class="text-sm text-gray-500">Section Ranking</p>
                        <p class="text-2xl font-bold text-orange-600">
                            #{{ Auth::user()->section_ranking ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function uploadProfilePicture(input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('profile_picture', input.files[0]);
            
            fetch('/profile/upload-picture', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profileImage').src = data.image_url + '?t=' + new Date().getTime();
                    showNotification('Profile picture updated successfully!', 'success');
                } else {
                    showNotification('Error uploading picture: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error uploading picture', 'error');
            });
        }
    }
    
    function showNotification(message, type) {
        // You can use SweetAlert or custom notification
        alert(message);
    }
</script>
@endpush
@endsection