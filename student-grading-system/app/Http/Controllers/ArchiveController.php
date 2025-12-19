<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    // Display archived students
    public function index()
    {
        // Get only soft deleted students
        $students = Student::onlyTrashed()
            ->with('grades')
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);
        
        return view('archives.index', compact('students'));
    }
    
    // Restore archived student
    public function restore($id)
    {
        try {
            $student = Student::onlyTrashed()->findOrFail($id);
            $student->restore();
            
            return redirect()->route('archives.index')
                ->with('success', 'Student "' . $student->name . '" has been restored successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('archives.index')
                ->with('error', 'Error restoring student: ' . $e->getMessage());
        }
    }
    
    // Permanently delete student
    public function forceDelete($id)
    {
        try {
            $student = Student::onlyTrashed()->findOrFail($id);
            
            // Delete related grades first
            $student->grades()->delete();
            
            // Get student name for message
            $studentName = $student->name;
            
            // Permanently delete student
            $student->forceDelete();
            
            return redirect()->route('archives.index')
                ->with('success', 'Student "' . $studentName . '" has been permanently deleted!');
                
        } catch (\Exception $e) {
            return redirect()->route('archives.index')
                ->with('error', 'Error deleting student: ' . $e->getMessage());
        }
    }
}