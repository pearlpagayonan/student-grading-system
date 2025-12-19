<!-- resources/views/grades/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Grade to Student</h2>
    
    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Select Student</label>
            <select name="student_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->name }} ({{ $student->student_id }})
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Grade</label>
            <input type="number" name="grade" step="0.01" min="0" max="100" 
                   class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Grade</button>
    </form>
</div>
@endsection