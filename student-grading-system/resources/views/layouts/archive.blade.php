@extends('layouts.app')

@section('title', 'Archived Students')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Archived Students</h1>
        <a href="{{ route('students.index') }}" class="btn-teal">
            <i class="fas fa-arrow-left mr-2"></i> Back to Active Students
        </a>
    </div>
    
    <!-- Archived Students Table -->
    <div class="card">
        @if($students->count() > 0)
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Section</th>
                        <th>Year Level</th>
                        <th>Archived Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <img src="{{ $student->profile_picture ? asset('storage/profile-pictures/' . basename($student->profile_picture)) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&color=008080&background=E0F2F1' }}" 
                                     alt="{{ $student->name }}" 
                                     class="w-8 h-8 rounded-full">
                                <span>{{ $student->name }}</span>
                            </div>
                        </td>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->section }}</td>
                        <td>{{ $student->year_level }}</td>
                        <td>{{ $student->deleted_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <form action="{{ route('students.restore', $student->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-800"
                                            onclick="return confirm('Restore this student?')">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                                
                                <form action="{{ route('students.force-delete', $student->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Permanently delete this student? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i> Delete Permanently
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $students->links() }}
        </div>
        @else
        <div class="text-center py-8">
            <i class="fas fa-archive text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">No archived students found