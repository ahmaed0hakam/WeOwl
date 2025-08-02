@extends('layouts.app')

@section('title', 'Teacher Dashboard - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="welcome">Welcome back, {{ $teacher->name }}!</h2>
                            <p class="text-muted">Here's what's happening with your classes today.</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0"><strong>Subject:</strong> {{ $teacher->subject }}</p>
                            <p class="mb-0"><strong>Experience:</strong> {{ $teacher->experience }} years</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="content">
                        <div class="number">{{ $totalClasses }}</div>
                        <div class="label">Total Classes</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="content">
                        <div class="number">{{ $totalStudents }}</div>
                        <div class="label">Total Students</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="content">
                        <div class="number">{{ \App\Models\Grade::where('teacher_id', session('teacher_id'))->count() }}</div>
                        <div class="label">Grades Added</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="content">
                        <div class="number">{{ $unreadMessages }}</div>
                        <div class="label">Unread Messages</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.classes') }}" class="btn btn-primary w-100">
                                <i class="fas fa-chalkboard"></i><br>
                                My Classes
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.grades') }}" class="btn btn-success w-100">
                                <i class="fas fa-graduation-cap"></i><br>
                                Manage Grades
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.attendance') }}" class="btn btn-warning w-100">
                                <i class="fas fa-calendar-check"></i><br>
                                Mark Attendance
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.chats') }}" class="btn btn-info w-100">
                                <i class="fas fa-comments"></i><br>
                                Chat with Parents
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Classes Overview -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>My Classes</h3>
                        <a href="{{ route('teacher.classes') }}" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                    
                    @if($classes->count() > 0)
                    <div class="row">
                        @foreach($classes->take(3) as $class)
                        <div class="col-md-4 mb-3">
                            <div class="class-card">
                                <div class="class-header">
                                    <h4>{{ $class->name }}</h4>
                                    <span class="badge bg-primary">{{ $class->students->count() }} students</span>
                                </div>
                                <div class="class-details">
                                    <p><strong>Subject:</strong> {{ $class->subject }}</p>
                                    <p><strong>Schedule:</strong> {{ $class->schedule ?? 'Not specified' }}</p>
                                    <p><strong>Room:</strong> {{ $class->room ?? 'Not specified' }}</p>
                                </div>
                                <div class="class-actions">
                                    <a href="{{ route('teacher.view-class', $class->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted">
                        <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                        <p>No classes assigned yet. Please contact the administrator.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="dashboard-card">
                    <h3>Recent Grades</h3>
                    @php
                        $recentGrades = \App\Models\Grade::with(['student'])
                            ->where('teacher_id', session('teacher_id'))
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($recentGrades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentGrades as $grade)
                                <tr>
                                    <td>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</td>
                                    <td>{{ $grade->subject }}</td>
                                    <td>
                                        <span class="badge bg-{{ $grade->grade == 'A' || $grade->grade == 'A+' ? 'success' : ($grade->grade == 'F' ? 'danger' : 'warning') }}">
                                            {{ $grade->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->created_at->format('M d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted">
                        <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                        <p>No grades added yet</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="dashboard-card">
                    <h3>Recent Attendance</h3>
                    @php
                        $recentAttendance = \App\Models\Attendance::with(['student'])
                            ->where('teacher_id', session('teacher_id'))
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($recentAttendance->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAttendance as $record)
                                <tr>
                                    <td>{{ $record->student->first_name }} {{ $record->student->last_name }}</td>
                                    <td>{{ $record->date->format('M d') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $record->status == 'present' ? 'success' : ($record->status == 'absent' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $record->time_in ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted">
                        <i class="fas fa-calendar-check fa-2x mb-2"></i>
                        <p>No attendance records yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .class-card {
            background: rgba(52, 58, 64, 0.5);
            border: 1px solid rgba(245, 177, 112, 0.2);
            border-radius: 10px;
            padding: 15px;
            height: 100%;
        }
        
        .class-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .class-header h4 {
            margin: 0;
            color: #ffffff;
        }
        
        .class-details p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .class-actions {
            margin-top: 15px;
        }
    </style>
    
    @include('layouts.partials.footer')
</div>
@endsection 