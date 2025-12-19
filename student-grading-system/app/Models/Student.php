<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ADD THIS

class Student extends Model
{
    use SoftDeletes; // ADD THIS LINE
    
    protected $fillable = [
        'student_number',
        'name',
        'email',
        'gender',
        'section',
        'year_level',
        'profile_picture',
        'address',
        'birthdate',
        'contact_number',
        'guardian_name',
        'guardian_contact',
        'average_grade',
        'status'
    ];
    
    protected $casts = [
        'birthdate' => 'date',
        'average_grade' => 'decimal:2'
    ];
    
    // ============ ADD THIS LINE ============
    protected $dates = ['deleted_at'];
    // ======================================
    
    // 1. Grades Relationship
// app/Models/Student.php
public function grades()
{
    return $this->hasMany(Grade::class, 'student_number', 'student_number');
}
    
    // 2. Get Grades Count
    public function getGradesCountAttribute()
    {
        return $this->grades()->count();
    }
    
    // 3. Get Average Grade (computed from actual grades)
    public function getComputedAverageGradeAttribute()
    {
        $grades = $this->grades;
        
        if ($grades->isEmpty()) {
            return 0.00;
        }
        
        $total = $grades->sum(function($grade) {
            return $grade->grade * $grade->units;
        });
        
        $totalUnits = $grades->sum('units');
        
        return $totalUnits > 0 ? round($total / $totalUnits, 2) : 0;
    }
    
    // 4. Get Status Color
    public function getStatusColorAttribute()
    {
        switch($this->status) {
            case 'Active': return 'success';
            case 'Inactive': return 'secondary';
            case 'Transferred': return 'warning';
            case 'Graduated': return 'info';
            default: return 'light';
        }
    }
    
    // 5. Get Profile Picture URL
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture && file_exists(storage_path('app/public/' . $this->profile_picture))) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Generate avatar based on gender
        $gender = strtolower($this->gender);
        $avatarStyle = ($gender == 'female') ? 'avataaars' : 'avataaars';
        return "https://api.dicebear.com/7.x/{$avatarStyle}/svg?seed=" . urlencode($this->name) . 
               "&backgroundColor=008080&textColor=ffffff";
    }
    
    // 6. Get Gender Badge Class (ADD THIS)
    public function getGenderBadgeClassAttribute()
    {
        return $this->gender == 'Male' ? 'badge-male' : 'badge-female';
    }
}