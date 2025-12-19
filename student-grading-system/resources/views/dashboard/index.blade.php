@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .chart-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }
    
    .chart-box { 
        flex: 1;
        min-width: 300px;
        height: 300px; 
        background: white;
        border-radius: 10px;
        padding: 20px; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .stat-card h3 {
        color: #008080;
        margin-bottom: 10px;
        font-size: 16px;
    }
    
    .stat-card .number {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .stat-card.total .number { color: #FFA500; }
    .stat-card.male .number { color: #1565C0; }
    .stat-card.female .number { color: #C2185B; }
    .stat-card.average .number { color: #4CAF50; }
</style>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="header">
        <h1><i class="fas fa-home"></i> Dashboard Overview</h1>
        <div style="color: #666;">Welcome to your Grading System Dashboard</div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="stat-card total">
            <h3><i class="fas fa-users"></i> Total Students</h3>
            <div class="number">{{ $totalStudents ?? 0 }}</div>
            <div style="font-size: 12px; color: #888;">Active students</div>
        </div>
        
        <div class="stat-card male">
            <h3><i class="fas fa-mars"></i> Male Students</h3>
            <div class="number">{{ $maleStudents ?? 0 }}</div>
            <div style="font-size: 12px; color: #888;">{{ $totalStudents > 0 ? round(($maleStudents/$totalStudents)*100, 1) : 0 }}%</div>
        </div>
        
        <div class="stat-card female">
            <h3><i class="fas fa-venus"></i> Female Students</h3>
            <div class="number">{{ $femaleStudents ?? 0 }}</div>
            <div style="font-size: 12px; color: #888;">{{ $totalStudents > 0 ? round(($femaleStudents/$totalStudents)*100, 1) : 0 }}%</div>
        </div>
        
        <div class="stat-card average">
            <h3><i class="fas fa-star"></i> Average Grade</h3>
            <div class="number">{{ number_format($averageGrade ?? 0, 2) }}</div>
            <div style="font-size: 12px; color: #888;">Overall GPA</div>
        </div>
    </div>
    
    <!-- Charts -->
    <div class="chart-container">
        <div class="chart-box">
            <h3><i class="fas fa-chart-bar"></i> Section Distribution</h3>
            <canvas id="sectionChart"></canvas>
        </div>
        
        <div class="chart-box">
            <h3><i class="fas fa-chart-pie"></i> Grade Distribution</h3>
            <canvas id="gradeChart"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📊 Dashboard loaded');
        
        @if(isset($sections) && !$sections->isEmpty())
            createSectionChart();
        @endif
        
        @if(isset($gradeDistribution))
            createGradeChart();
        @endif
    });
    
    function createSectionChart() {
        const ctx = document.getElementById('sectionChart');
        if (!ctx) return;
        
        const sections = @json($sections->pluck('section'));
        const counts = @json($sections->pluck('total'));
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: sections,
                datasets: [{
                    label: 'Students per Section',
                    data: counts,
                    backgroundColor: '#008080',
                    borderColor: '#006666',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
    
    function createGradeChart() {
        const ctx = document.getElementById('gradeChart');
        if (!ctx) return;
        
        @if(isset($gradeDistribution))
            const data = @json($gradeDistribution);
            const values = [
                data['90-100'] || 0,
                data['80-89'] || 0,
                data['70-79'] || 0,
                data['Below 70'] || 0
            ];
            
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        '90-100 (Excellent)',
                        '80-89 (Very Good)', 
                        '70-79 (Good)', 
                        'Below 70 (Needs Help)'
                    ],
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            '#FFA500',
                            '#008080', 
                            '#4CAF50', 
                            '#F44336'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        @endif
    }
</script>
@endsection