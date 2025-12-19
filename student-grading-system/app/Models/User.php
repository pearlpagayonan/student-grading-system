<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
        'profile_picture', 'contact_number', 'student_id',
        'teacher_id', 'year_level', 'section', 'gender',
        'first_login'
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    // Add these methods
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function isTeacher()
    {
        return $this->role_id == 2;
    }

    public function isStudent()
    {
        return $this->role_id == 3;
    }

    public function getAverageGradeAttribute()
    {
        $grades = $this->grades;
        if ($grades->isEmpty()) return 0;
        
        $total = $grades->sum(function($grade) {
            return $grade->grade * $grade->units;
        });
        
        $totalUnits = $grades->sum('units');
        
        return $totalUnits > 0 ? round($total / $totalUnits, 2) : 0;
    }

    public function getSectionRankingAttribute()
    {
        if (!$this->section) return null;

        $students = User::where('section', $this->section)
            ->where('role_id', 3)
            ->whereNull('deleted_at')
            ->with('grades')
            ->get()
            ->sortByDesc(function($student) {
                return $student->average_grade;
            })
            ->values();

        $rank = $students->search(function($student) {
            return $student->id === $this->id;
        });

        return $rank !== false ? $rank + 1 : null;
    }

// app/Models/User.php
public function getFullProfilePictureAttribute()
{
    if ($this->profile_picture) {
        return asset('storage/' . $this->profile_picture);
    }
    
    return asset('images/default-avatar.png');
}

    // Add this method to auto-assign role on retrieval
protected static function boot()
{
    parent::boot();
    
    static::retrieved(function ($user) {
        // Auto-assign role if missing
        if (!$user->role_id) {
            if ($user->teacher_id) {
                $user->role_id = 2;
            } elseif ($user->student_id) {
                $user->role_id = 3;
            } else {
                $user->role_id = 1;
            }
            $user->saveQuietly(); // Save without triggering events
        }
    });
}
}