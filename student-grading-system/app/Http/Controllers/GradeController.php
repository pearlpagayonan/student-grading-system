<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class GradeController extends Controller
{
    public function manage()
    {
        try {
            // Check if grades table exists
            if (!Schema::hasTable('grades')) {
                // Return view with empty data if table doesn't exist
                return view('grades.manage', [
                    'students' => Student::orderBy('name')->get(),
                    'grades' => collect(),
                    'subjects' => collect()
                ]);
            }
            
            // Kunin ang mga students kasama ang kanilang grades
            $students = Student::with(['grades' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])->orderBy('name')->get();
            
            // Kunin lahat ng grades para sa statistics
            $grades = Grade::with('student')->get();
            
            // Kunin ang unique subjects
            $subjects = Grade::distinct()->pluck('subject')->filter()->values();
            
            return view('grades.manage', compact('students', 'grades', 'subjects'));
            
        } catch (\Exception $e) {
            // Log error and return empty data
            \Log::error('GradeController manage error: ' . $e->getMessage());
            
            return view('grades.manage', [
                'students' => Student::orderBy('name')->get(),
                'grades' => collect(),
                'subjects' => collect(),
                'error' => 'Grades table not available yet.'
            ]);
        }
    }
    
    public function store(Request $request)
    {
        \Log::info('=== GRADE STORE ===');
        \Log::info('Request:', $request->all());
        
        try {
            // Validate - ONLY student_number, NO student_id
            $validated = $request->validate([
                'student_number' => 'required|string|exists:students,student_number',
                'subject' => 'required|string|max:255',
                'grade' => 'required|numeric|min:0|max:100',
                'units' => 'required|integer|min:1|max:5',
                'school_year' => 'required|string',
                'semester' => 'required|string',
            ]);
            
            \Log::info('Validated:', $validated);
            
            // Get student to update average grade
            $student = Student::where('student_number', $validated['student_number'])->first();
            
            // Create grade
            $grade = Grade::create($validated);
            
            \Log::info('Grade created:', $grade->toArray());
            
            // Update student's average grade
            $this->updateStudentAverageGrade($student->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Grade added successfully!',
                'grade' => $grade
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Grade store error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function updateStudentAverageGrade($studentId)
    {
        $student = Student::findOrFail($studentId);
        
        // Get all grades for this student via student_number
        $grades = Grade::where('student_number', $student->student_number)->get();
        
        if ($grades->count() > 0) {
            $average = $grades->avg('grade');
            $student->update([
                'average_grade' => round($average, 2)
            ]);
        }
    }
public function update(Request $request, Grade $grade)
{
    \Log::info('=== GRADE UPDATE ===');
    \Log::info('Request:', $request->all());
    \Log::info('Grade ID:', ['id' => $grade->id]);
    
    try {
        $validated = $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'units' => 'required|integer|min:1|max:5',
            'school_year' => 'required|string',
            'semester' => 'required|string',
        ]);
        
        \Log::info('Validated:', $validated);
        
        $grade->update($validated);
        
        \Log::info('Grade updated:', $grade->toArray());
        
        // Update student's average grade
        $student = Student::where('student_number', $grade->student_number)->first();
        if ($student) {
            $this->updateStudentAverageGrade($student->id);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Grade updated successfully!',
            'grade' => $grade
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Grade update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
    
public function destroy(Grade $grade)
{
    \Log::info('=== GRADE DELETE ===');
    \Log::info('Grade to delete:', $grade->toArray());
    
    try {
        // Get student before deletion
        $student = Student::where('student_number', $grade->student_number)->first();
        
        $grade->delete();
        
        \Log::info('Grade deleted successfully');
        
        // Update student's average grade
        if ($student) {
            $this->updateStudentAverageGrade($student->id);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Grade deleted successfully!'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Grade delete error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }}
    
    public function myGrades()
    {
        // For student view - kunin ang grades ng current user
        $user = auth()->user();
        
        // Kunin ang student record ng current user
        $student = Student::where('email', $user->email)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }
        
        $grades = $student->grades()->orderBy('subject')->get();
        
        // Compute average
        $averageGrade = 0;
        if ($grades->count() > 0) {
            $total = $grades->sum(function($grade) {
                return $grade->grade * $grade->units;
            });
            $totalUnits = $grades->sum('units');
            $averageGrade = $totalUnits > 0 ? round($total / $totalUnits, 2) : 0;
        }
        
        return view('grades.my-grades', compact('grades', 'averageGrade'));
    }
    
    public function create()
    {
        $students = Student::orderBy('name')->get();
        $schoolYears = ['2023-2024', '2024-2025', '2025-2026'];
        $semesters = ['1st Semester', '2nd Semester', 'Summer'];
        
        return view('grades.manage', compact('students', 'schoolYears', 'semesters'));
    }
    
    public function studentGrades($studentId)
    {
        try {
            $student = Student::findOrFail($studentId);
            
            // Get grades using student_number
            $grades = Grade::where('student_number', $student->student_number)
                          ->orderBy('created_at', 'desc')
                          ->get();
            
            $totalUnits = $grades->sum('units');
            $average = $grades->count() > 0 ? $grades->avg('grade') : 0;
            
            return response()->json([
                'success' => true,
                'student' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'student_number' => $student->student_number,
                    'email' => $student->email
                ],
                'grades' => $grades->map(function($grade) {
                    return [
                        'id' => $grade->id,
                        'subject' => $grade->subject,
                        'grade' => $grade->grade,
                        'units' => $grade->units,
                        'school_year' => $grade->school_year,
                        'semester' => $grade->semester,
                        'created_at' => $grade->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $grade->updated_at->format('Y-m-d H:i:s')
                    ];
                }),
                'totalUnits' => $totalUnits,
                'average' => round($average, 2),
                'gradesCount' => $grades->count()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Student grades error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Add a method to get all subjects
    public function getSubjects()
    {
        $subjects = Grade::distinct()->pluck('subject')->filter()->values();
        
        return response()->json([
            'success' => true,
            'subjects' => $subjects
        ]);
    }
    
    // Add a method to get grade statistics
    public function getStatistics()
    {
        $totalGrades = Grade::count();
        $totalStudents = Student::has('grades')->count();
        $overallAverage = Grade::avg('grade');
        
        $gradeDistribution = [
            '90-100' => Grade::where('grade', '>=', 90)->count(),
            '80-89' => Grade::whereBetween('grade', [80, 89.99])->count(),
            '75-79' => Grade::whereBetween('grade', [75, 79.99])->count(),
            'Below 75' => Grade::where('grade', '<', 75)->count(),
        ];
        
        return response()->json([
            'success' => true,
            'totalGrades' => $totalGrades,
            'totalStudentsWithGrades' => $totalStudents,
            'overallAverage' => round($overallAverage, 2),
            'gradeDistribution' => $gradeDistribution
        ]);
    }
    public function edit(Grade $grade)
{
    try {
        return response()->json([
            'success' => true,
            'grade' => [
                'id' => $grade->id,
                'subject' => $grade->subject,
                'grade' => $grade->grade,
                'units' => $grade->units,
                'school_year' => $grade->school_year,
                'semester' => $grade->semester,
                'student_number' => $grade->student_number,
                'created_at' => $grade->created_at,
                'updated_at' => $grade->updated_at
            ]
        ]);
    } catch (\Exception $e) {
        \Log::error('Grade edit error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}