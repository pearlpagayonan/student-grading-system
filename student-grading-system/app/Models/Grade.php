<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_number',
        'subject',
        'grade',
        'units',
        'school_year',
        'semester',
        'remarks'
    ];
    
    protected $casts = [
        'grade' => 'decimal:2',
        'units' => 'integer'
    ];
    
    // Relationship to Student
// app/Models/Grade.php
public function student()
{
    return $this->belongsTo(Student::class, 'student_number', 'student_number');
    // This means: grades.student_number = students.student_number
}
    
    // Get Grade Status
    public function getStatusAttribute()
    {
        if ($this->grade >= 90) return 'Excellent';
        if ($this->grade >= 80) return 'Good';
        if ($this->grade >= 75) return 'Average';
        return 'Poor';
    }
    
    // Get Grade Color
    public function getStatusColorAttribute()
    {
        if ($this->grade >= 90) return 'success';
        if ($this->grade >= 80) return 'primary';
        if ($this->grade >= 75) return 'warning';
        return 'danger';
    }
}