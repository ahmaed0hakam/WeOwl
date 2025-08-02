@extends('layouts.app')

@section('title', 'Teacher Profile - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">My Profile</h2>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Profile Information -->
            <div class="col-md-8 mb-4">
                <div class="dashboard-card">
                    <h3>Profile Information</h3>
                    <form action="{{ route('teacher.update-profile') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $teacher->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" value="{{ $teacher->email }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" name="subject" value="{{ $teacher->subject }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Years of Experience</label>
                                    <input type="number" class="form-control" name="experience" value="{{ $teacher->experience }}" min="0" max="50">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $teacher->phone ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qualification" class="form-label">Qualification</label>
                                    <input type="text" class="form-control" name="qualification" value="{{ $teacher->qualification ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3">{{ $teacher->address ?? '' }}</textarea>
                        </div>
                        
                        <hr>
                        
                        <h4>Change Password</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="new_password_confirmation">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Account Statistics -->
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <h3>Account Statistics</h3>
                    <div class="stats-list">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ $teacher->created_at->diffForHumans() }}</div>
                                <div class="stat-label">Account Created</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ \App\Models\ClassRoom::where('teacher_id', $teacher->id)->count() }}</div>
                                <div class="stat-label">Classes Assigned</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ \App\Models\Student::whereHas('classRoom', function($q) use ($teacher) { $q->where('teacher_id', $teacher->id); })->count() }}</div>
                                <div class="stat-label">Total Students</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ \App\Models\Grade::where('teacher_id', $teacher->id)->count() }}</div>
                                <div class="stat-label">Grades Added</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ \App\Models\Attendance::where('teacher_id', $teacher->id)->count() }}</div>
                                <div class="stat-label">Attendance Records</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">{{ \App\Models\Notification::where('recipient_id', $teacher->id)->where('recipient_type', 'teacher')->count() }}</div>
                                <div class="stat-label">Messages Received</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .stats-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: rgba(52, 58, 64, 0.3);
            border-radius: 8px;
            border: 1px solid rgba(245, 177, 112, 0.2);
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(245, 177, 112, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #f5b170;
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 2px;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
    
    @include('layouts.partials.footer')
</div>
@endsection 