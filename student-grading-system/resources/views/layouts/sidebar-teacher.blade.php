<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Login - Setup Your Profile</title>
    <style>
        * { font-family: 'Tahoma', sans-serif; }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        
        .setup-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #008080;
            margin: 0;
            font-size: 28px;
        }
        
        .header p {
            color: #666;
            margin-top: 5px;
            font-size: 14px;
        }
        
        .profile-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #008080;
            margin: 0 auto 20px;
            display: block;
        }
        
        .upload-btn {
            display: block;
            width: 100px;
            margin: 0 auto 30px;
            padding: 8px;
            background: #FFA500;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #FFA500;
        }
        
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #008080;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            background: #006666;
        }
        
        .welcome-message {
            background: #E0F2F1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #008080;
        }
        
        .student-info {
            background: #FFF4E0;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #FFA500;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: 600;
            color: #333;
        }
        
        .info-value {
            color: #008080;
        }
    </style>
</head>
<body>
    <div class="setup-card">
        <div class="header">
            <h1>👋 Welcome, {{ auth()->user()->name }}!</h1>
            <p>Please setup your profile to continue</p>
        </div>
        
        <div class="welcome-message">
            <strong>First Time Login</strong>
            <p style="margin: 5px 0 0 0; font-size: 14px;">Please change your temporary password and upload a profile picture.</p>
        </div>
        
        <div class="student-info">
            <div class="info-item">
                <span class="info-label">Student ID:</span>
                <span class="info-value">{{ auth()->user()->student_id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Section:</span>
                <span class="info-value">{{ auth()->user()->section }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Year Level:</span>
                <span class="info-value">{{ auth()->user()->year_level }}</span>
            </div>
        </div>
        
        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <p style="margin: 5px 0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('profile.update-first-login') }}" enctype="multipart/form-data">
            @csrf
            
            <img id="profilePreview" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=008080&background=E0F2F1&size=100" 
                 alt="Profile Preview" class="profile-preview">
            
            <label for="profile_picture" class="upload-btn">
                📷 Upload Photo
            </label>
            <input type="file" id="profile_picture" name="profile_picture" 
                   accept="image/*" style="display: none;" onchange="previewImage(this)">
            
            <div class="form-group">
                <label for="contact_number">Contact Number (Optional)</label>
                <input id="contact_number" type="text" name="contact_number" 
                       class="form-control" placeholder="e.g., 09123456789">
            </div>
            
            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" name="password" 
                       class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" 
                       class="form-control" required>
            </div>
            
            <button type="submit" class="btn-submit">
                Complete Setup & Continue
            </button>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        document.querySelector('.upload-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('profile_picture').click();
        });
    </script>
</body>
</html>