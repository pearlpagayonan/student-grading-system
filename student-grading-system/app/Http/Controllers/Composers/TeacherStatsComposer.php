<?php

namespace App\Http\View\Composers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherStatsComposer
{
    public function compose(View $view): void
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            $this->setDefaultValues($view);
            return;
        }
        
        $user = Auth::user();
        
        // Check if user is teacher
        if (!method_exists($user, 'isTeacher') || !$user->isTeacher()) {
            $this->setDefaultValues($view);
            return;
        }
        
        try {
            // Calculate top 10 students by average grade
            $topStudents = User::where('role_id', 3) // Student role
                ->whereNull('deleted_at')
                ->with('grades')
                ->get()
                ->map(function ($student) {
                    // Calculate average grade
                    $grades = $student->grades;
                    $student->average_grade = $grades->isNotEmpty() ? $grades->avg('grade') : 0;
                    return $student;
                })
                ->sortByDesc('average_grade')
                ->take(10);
            
            // Calculate total students
            $totalStudents = User::where('role_id', 3)
                ->whereNull('deleted_at')
                ->count();
            
            // Calculate male students
            $maleStudents = User::where('role_id', 3)
                ->where('gender', 'male')
                ->whereNull('deleted_at')
                ->count();
            
            // Calculate female students
            $femaleStudents = User::where('role_id', 3)
                ->where('gender', 'female')
                ->whereNull('deleted_at')
                ->count();
            
            // Pass data to view
            $view->with('topStudents', $topStudents);
            $view->with('totalStudents', $totalStudents);
            $view->with('maleStudents', $maleStudents);
            $view->with('femaleStudents', $femaleStudents);
            
        } catch (\Exception $e) {
            // If any error occurs, set default values
            $this->setDefaultValues($view);
        }
    }
    
    private function setDefaultValues(View $view): void
    {
        $view->with('topStudents', collect());
        $view->with('totalStudents', 0);
        $view->with('maleStudents', 0);
        $view->with('femaleStudents', 0);
    }
}