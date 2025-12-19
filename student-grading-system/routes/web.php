<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::middleware('guest')->group(function () {
    // Teacher Registration
    Route::get('register/teacher', [RegisteredUserController::class, 'createTeacher'])
                ->name('register.teacher');
    Route::post('register/teacher', [RegisteredUserController::class, 'storeTeacher']);
    
    // Student Registration
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Password Reset
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
    
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $students = \App\Models\Student::all();
        
        $totalStudents = $students->count();
        $maleStudents = $students->where('gender', 'Male')->count();
        $femaleStudents = $students->where('gender', 'Female')->count();
        
        $topStudents = $students->whereNotNull('average_grade')
            ->sortByDesc('average_grade')
            ->take(10);
        
        $sections = \DB::table('students')
            ->select('section', \DB::raw('COUNT(*) as total'))
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->groupBy('section')
            ->orderBy('section')
            ->get();
        
        $gradeDistribution = [
            '90-100' => $students->where('average_grade', '>=', 90)->count(),
            '80-89' => $students->whereBetween('average_grade', [80, 89.99])->count(),
            '70-79' => $students->whereBetween('average_grade', [70, 79.99])->count(),
            'Below 70' => $students->where('average_grade', '<', 70)->count(),
        ];
        
        return view('dashboard', compact(
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'topStudents',
            'sections',
            'gradeDistribution'
        ));
    })->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== STUDENT ROUTES ==========
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/', [StudentController::class, 'store'])->name('students.store');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    });
    // ====================================
    
    // ========== GRADE ROUTES ==========
    Route::prefix('grades')->group(function () {
        Route::get('/manage', [GradeController::class, 'manage'])->name('grades.manage');
        Route::get('/create', [GradeController::class, 'create'])->name('grades.create');
        Route::post('/', [GradeController::class, 'store'])->name('grades.store');
        Route::put('/{grade}', [GradeController::class, 'update'])->name('grades.update');
        Route::delete('/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
        
        // Additional routes for viewing specific grades
        Route::get('/student/{student}', [GradeController::class, 'studentGrades'])->name('grades.student');
    });
    // ==================================
    
    // ========== ARCHIVE ROUTES ==========
    Route::prefix('archives')->group(function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('archives.index');
        Route::post('/{student}/restore', [ArchiveController::class, 'restore'])->name('archives.restore');
        Route::delete('/{student}/force-delete', [ArchiveController::class, 'forceDelete'])->name('archives.forceDelete');
    });
    // ====================================
    
    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');
    
    // Password Confirmation
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
    // Password Update
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
Route::get('/grades/student/{student}', [GradeController::class, 'studentGrades'])->name('grades.student');
// Grade routes
Route::get('/grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});