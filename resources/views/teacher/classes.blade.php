@extends('layouts.app')

@section('title', 'My Classes - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">My Classes</h2>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Classes Overview -->
        <div class="row">
            @forelse($classes as $class)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="dashboard-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3>{{ $class->name }}</h3>
                        <span class="badge bg-primary">{{ $class->students->count() }} students</span>
                    </div>
                    
                    <div class="class-info mb-3">
                        <p><strong>Subject:</strong> {{ $class->subject }}</p>
                        <p><strong>Schedule:</strong> {{ $class->schedule ?? 'Not specified' }}</p>
                        <p><strong>Room:</strong> {{ $class->room ?? 'Not specified' }}</p>
                    </div>
                    
                    <div class="class-stats mb-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $class->students->count() }}</div>
                                    <div class="stat-label">Students</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $class->students->where('status', 'active')->count() }}</div>
                                    <div class="stat-label">Active</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $class->students->where('status', 'inactive')->count() }}</div>
                                    <div class="stat-label">Inactive</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="class-actions">
                        <div class="d-grid gap-2">
                            <a href="{{ route('teacher.view-class', $class->id) }}" class="btn btn-primary">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <div class="btn-group" role="group">
                                <a href="{{ route('teacher.grades') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-graduation-cap"></i> Grades
                                </a>
                                <a href="{{ route('teacher.attendance') }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-calendar-check"></i> Attendance
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="dashboard-card text-center">
                    <i class="fas fa-chalkboard-teacher fa-5x text-muted mb-4"></i>
                    <h3>No Classes Assigned</h3>
                    <p class="text-muted">You haven't been assigned to any classes yet. Please contact the administrator.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Quick Actions -->
        @if($classes->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.grades') }}" class="btn btn-primary w-100">
                                <i class="fas fa-graduation-cap"></i><br>
                                Manage Grades
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.attendance') }}" class="btn btn-success w-100">
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
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('teacher.profile') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-user"></i><br>
                                My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <style>
        .stat-item {
            padding: 10px;
        }
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #f5b170;
        }
        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .class-info p {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .class-actions {
            margin-top: auto;
        }
    </style>
    
    @include('layouts.partials.footer')
</div>
@endsection 