<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the View Composer
        View::composer('layouts.app', function ($view) {
            // Check if user is authenticated
            if (!auth()->check()) {
                $view->with('topStudents', collect());
                $view->with('totalStudents', 0);
                $view->with('maleStudents', 0);
                $view->with('femaleStudents', 0);
                return;
            }
            
            $user = auth()->user();
            
            // Check if user is teacher
            if (!method_exists($user, 'isTeacher') || !$user->isTeacher()) {
                $view->with('topStudents', collect());
                $view->with('totalStudents', 0);
                $view->with('maleStudents', 0);
                $view->with('femaleStudents', 0);
                return;
            }
            
            try {
                // Calculate top 10 students
                $topStudents = \App\Models\User::where('role_id', 3)
                    ->whereNull('deleted_at')
                    ->with('grades')
                    ->get()
                    ->map(function ($student) {
                        $grades = $student->grades;
                        $student->average_grade = $grades->isNotEmpty() ? $grades->avg('grade') : 0;
                        return $student;
                    })
                    ->sortByDesc('average_grade')
                    ->take(10);
                
                // Share with view
                $view->with('topStudents', $topStudents);
                $view->with('totalStudents', \App\Models\User::where('role_id', 3)->whereNull('deleted_at')->count());
                $view->with('maleStudents', \App\Models\User::where('role_id', 3)->where('gender', 'male')->whereNull('deleted_at')->count());
                $view->with('femaleStudents', \App\Models\User::where('role_id', 3)->where('gender', 'female')->whereNull('deleted_at')->count());
                
            } catch (\Exception $e) {
                // Default values on error
                $view->with('topStudents', collect());
                $view->with('totalStudents', 0);
                $view->with('maleStudents', 0);
                $view->with('femaleStudents', 0);
            }
        });
    }
}