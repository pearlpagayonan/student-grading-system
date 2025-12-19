<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Display all students WITH SEARCH FUNCTIONALITY
    public function index(Request $request) // ✅ Dapat may Request parameter
    {
        $query = Student::query();
        
        // SEARCH FUNCTIONALITY
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('student_number', 'LIKE', "%{$search}%")
                  ->orWhere('section', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('contact_number', 'LIKE', "%{$search}%");
            });
        }
        
        // Optional: Add sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $students = $query->paginate(10)->withQueryString();
        
        return view('students.index', compact('students'));
    }
    
    // Show create form
    public function create()
    {
        return view('students.create');
    }
    
    // STORE STUDENT - FIXED
 // app/Http/Controllers/StudentController.php

public function store(Request $request)
{
    // DEBUG: Check if form reaches here
    \Log::info('Student store called', ['data' => $request->except('_token')]);
    
    // VALIDATION RULES
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'student_number' => 'nullable|string|unique:students,student_number',
        'email' => 'required|email|unique:students,email',
        'contact_number' => 'nullable|string|max:20',
        'gender' => 'required|in:Male,Female',
        'birthdate' => 'nullable|date',
        'section' => 'required|string',
        'year_level' => 'required|string',
        'address' => 'nullable|string',
        'guardian_name' => 'nullable|string|max:255',
        'guardian_contact' => 'nullable|string|max:20',
        'average_grade' => 'nullable|numeric|min:0|max:100',
        'status' => 'nullable|string|in:Active,Inactive,Transferred,Graduated',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    // 1. Auto-generate student number if blank
    if (empty($validated['student_number'])) {
        $year = date('Y');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $validated['student_number'] = $year . '-' . $random;
    }
    
    // 2. Handle profile picture
    if ($request->hasFile('profile_picture')) {
        // Upload user's file
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validated['profile_picture'] = $path;
    } else {
        // AUTO-GENERATE PROFILE PICTURE
        $gender = strtolower($validated['gender'] ?? 'other');
        $avatarStyle = ($gender == 'female') ? 'avataaars' : 'avataaars';
        $avatarUrl = "https://api.dicebear.com/7.x/{$avatarStyle}/svg?seed=" . urlencode($validated['name']) . 
                    "&backgroundColor=008080&textColor=ffffff";
        
        // Download and save avatar
        $avatarContent = @file_get_contents($avatarUrl);
        if ($avatarContent !== false) {
            $filename = 'avatar_' . $validated['student_number'] . '_' . time() . '.svg';
            $path = 'profile_pictures/' . $filename;
            Storage::disk('public')->put($path, $avatarContent);
            $validated['profile_picture'] = $path;
        }
    }
    
    // 3. Set default status if not provided
    if (!isset($validated['status']) || empty($validated['status'])) {
        $validated['status'] = 'Active';
    }
    
    // 4. Set default average grade if not provided
    if (!isset($validated['average_grade']) || empty($validated['average_grade'])) {
        $validated['average_grade'] = 0.00;
    }
    
    // 5. Create the student
    try {
        $student = Student::create($validated);
        \Log::info('Student created successfully', ['id' => $student->id]);
        
        return redirect()->route('students.index')
            ->with('success', 'Student "' . $student->name . '" added successfully!')
            ->with('student_number', $student->student_number);
            
    } catch (\Exception $e) {
        \Log::error('Error creating student: ' . $e->getMessage());
        
        return back()->withInput()
            ->with('error', 'Error creating student: ' . $e->getMessage());
    }
}
    
    // Show single student
    public function show(Student $student)
    {
         return redirect()->route('students.index');
    }
    
    // Edit student form
public function edit(Student $student)
{
    \Log::info('Editing student ID: ' . $student->id);
    \Log::info('Student data:', $student->toArray());
    
    // Check if it's an AJAX request (for modal)
    if (request()->ajax() || request()->wantsJson()) {
        return response()->json([
            'success' => true,
            'html' => view('students.edit-modal', compact('student'))->render()
        ]);
    }
    
    return view('students.edit', compact('student'));
}
    
    // Update student
// Update mo ang validation rules sa update() method
public function update(Request $request, Student $student)
{
    \Log::info('Updating student ID: ' . $student->id);
    \Log::info('Update request data:', $request->all());
    
    // UPDATED VALIDATION RULES - ADD GUARDIAN FIELDS
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'student_number' => 'nullable|string|unique:students,student_number,' . $student->id,
        'email' => 'required|email|unique:students,email,' . $student->id,
        'contact_number' => 'nullable|string|max:20',
        'gender' => 'required|in:Male,Female',
        'birthdate' => 'nullable|date',
        'section' => 'required|string',
        'year_level' => 'required|string',
        'address' => 'nullable|string',
        'guardian_name' => 'nullable|string|max:255',  // ✅ ADD THIS
        'guardian_contact' => 'nullable|string|max:20', // ✅ ADD THIS
        'average_grade' => 'nullable|numeric|min:0|max:100',
        'status' => 'nullable|string|in:Active,Inactive,Transferred,Graduated',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    \Log::info('Validated data:', $validated);
    
    // Handle profile picture upload if provided
    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if exists
        if ($student->profile_picture) {
            Storage::disk('public')->delete($student->profile_picture);
        }
        
        // Upload new file
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validated['profile_picture'] = $path;
    }
    
    $student->update($validated);
    
    \Log::info('Student updated successfully');
    
    // Return JSON response for AJAX
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully!',
            'student' => $student
        ]);
    }
    
    return redirect()->route('students.index')
        ->with('success', 'Student updated successfully!');
}
    // Delete (Archive) student
    public function destroy(Student $student)
    {
        $student->delete();
        
        return redirect()->route('students.index')
            ->with('success', 'Student archived successfully!');
    }
}