@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-teal-50 to-blue-50 border-l-4 border-teal-500 p-6 rounded">
        <div class="flex items-center">
            <div class="mr-4">
                <img src="{{ Auth::user()->profile_picture ? asset('storage/profile-pictures/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=008080&background=E0F2F1&size=100' }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="w-16 h-16 rounded-full border-4 border-white shadow">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mt-1">
                    {{ Auth::user()->student_id }} • {{ Auth::user()->section }} • {{ Auth::user()->year_level }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stats-card">
            <div class="text-3xl mb-2">📊</div>
            <h3 class="text-3xl font-bold">{{ number_format($averageGrade, 2) }}</h3>
            <p>Average Grade</p>
        </div>
        
        <div class="stats-card" style="background: linear-gradient(135deg, #FFA500, #E69500);">
            <div class="text-3xl mb-2">🏆</div>
            <h3 class="text-3xl font-bold">#{{ $sectionRanking ?? 'N/A' }}</h3>
            <p>Section Ranking</p>
        </div>
        
        <div class="stats-card" style="background: linear-gradient(135deg, #9C27B0, #7B1FA2);">
            <div class="text-3xl mb-2">📚</div>
            <h3 class="text-3xl font-bold">{{ Auth::user()->grades->count() }}</h3>
            <p>Subjects Taken</p>
        </div>
    </div>
    
    <!-- Recent Grades -->
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">📝 Recent Grades</h2>
            <a href="{{ route('grades.mygrades') }}" class="btn-teal text-sm">
                View All Grades
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Units</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse(Auth::user()->grades()->latest()->take(5)->get() as $grade)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $grade->subject }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-bold 
                                {{ $grade->grade >= 90 ? 'bg-green-100 text-green-800' : 
                                   ($grade->grade >= 80 ? 'bg-blue-100 text-blue-800' : 
                                   ($grade->grade >= 75 ? 'bg-orange-100 text-orange-800' : 
                                   'bg-red-100 text-red-800')) }}">
                                {{ number_format($grade->grade, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $grade->units }}</td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-600">{{ $grade->semester }}</span>
                            <div class="text-xs text-gray-500">{{ $grade->school_year }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($grade->grade >= 90)
                                <span class="text-green-600 font-medium">Excellent</span>
                            @elseif($grade->grade >= 80)
                                <span class="text-blue-600 font-medium">Very Good</span>
                            @elseif($grade->grade >= 75)
                                <span class="text-orange-600 font-medium">Satisfactory</span>
                            @else
                                <span class="text-red-600 font-medium">Needs Improvement</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            No grades recorded yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card">
            <h2 class="text-xl font-bold text-gray-800 mb-4">👤 Profile Management</h2>
            <div class="space-y-3">
                <a href="{{ route('profile.edit') }}" class="block p-4 bg-teal-50 hover:bg-teal-100 rounded-lg transition">
                    <div class="flex items-center">
                        <span class="text-teal-500 mr-3">✏️</span>
                        <div>
                            <h3 class="font-semibold text-gray-800">Edit Profile</h3>
                            <p class="text-sm text-gray-600">Update your contact information</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('profile.edit') }}#password" class="block p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition">
                    <div class="flex items-center">
                        <span class="text-orange-500 mr-3">🔒</span>
                        <div>
                            <h3 class="font-semibold text-gray-800">Change Password</h3>
                            <p class="text-sm text-gray-600">Update your account password</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="card">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📚 Academic Information</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-gray-50 rounded">
                        <p class="text-sm text-gray-500">Student ID</p>
                        <p class="font-semibold">{{ Auth::user()->student_id }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <p class="text-sm text-gray-500">Section</p>
                        <p class="font-semibold">{{ Auth::user()->section }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-gray-50 rounded">
                        <p class="text-sm text-gray-500">Year Level</p>
                        <p class="font-semibold">{{ Auth::user()->year_level }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-semibold">{{ ucfirst(Auth::user()->gender) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection