<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        
        // AUTO-ASSIGN ROLE BASED ON teacher_id OR student_id
        if (!$user->role_id) {
            if ($user->teacher_id) {
                $user->role_id = 2; // Teacher
            } elseif ($user->student_id) {
                $user->role_id = 3; // Student
            } else {
                $user->role_id = 1; // Admin (fallback)
            }
            $user->save();
            $user->refresh();
        }
        
        // Load the role relationship
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }
        
        // If role still doesn't exist (possible database issue), allow access
        if (!$user->role) {
            // Log the issue but allow access for now
            \Log::warning('User has no role assigned', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            return $next($request);
        }
        
        // Check if student is on first login
        if ($user->isStudent() && $user->first_login) {
            if ($request->route()->getName() !== 'first-login' && 
                $request->route()->getName() !== 'profile.update-first-login') {
                return redirect()->route('first-login');
            }
        }
        
        // Check if user has required role
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized access. Required role: ' . implode(', ', $roles) . '. Your role: ' . $user->role->name);
        }

        return $next($request);
    }
}