<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index()
{
    $totalStudents = Student::count();
    $maleStudents = Student::where('gender', 'male')->count();
    $femaleStudents = Student::where('gender', 'female')->count();
    
    $sections = Student::select('section', DB::raw('count(*) as total'))
        ->groupBy('section')
        ->get();
    
    // TIGNAN TO: 'dashboard.index' hindi 'dashboard'
    return view('dashboard.index', compact(
        'totalStudents', 
        'maleStudents', 
        'femaleStudents',
        'sections'
    ));

    }
    
    private function calculateGradeDistribution($students)
    {
        $distribution = [
            '90-100' => 0,
            '80-89' => 0,
            '70-79' => 0,
            'Below 70' => 0
        ];
        
        foreach ($students as $student) {
            $grade = $student->average_grade;
            
            if ($grade >= 90) {
                $distribution['90-100']++;
            } elseif ($grade >= 80) {
                $distribution['80-89']++;
            } elseif ($grade >= 70) {
                $distribution['70-79']++;
            } else {
                $distribution['Below 70']++;
            }
        }
        
        return $distribution;
    }
    
    private function showEmptyState()
    {
        // Show empty dashboard with sample data for demo
        $sections = collect([
            (object) ['section' => 'Section A', 'total' => 0],
            (object) ['section' => 'Section B', 'total' => 0],
        ]);
        
        $gradeDistribution = [
            '90-100' => 0,
            '80-89' => 0,
            '70-79' => 0,
            'Below 70' => 0
        ];
        
        $totalStudents = 0;
        $maleStudents = 0;
        $femaleStudents = 0;
        $topStudents = collect();
        
        return view('dashboard', compact(
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'topStudents',
            'sections',
            'gradeDistribution'
        ));
    }
}