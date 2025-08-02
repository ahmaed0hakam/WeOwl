@extends('layouts.app')

@section('title', 'Child Details - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Child Details</h2>
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Child Information -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="dashboard-card">
                    <h3 class="mb-3">Personal Information</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="{{ $child->first_name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="{{ $child->last_name }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Class</label>
                            <input type="text" class="form-control" value="{{ $child->class_name ?? 'Not Assigned' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Section</label>
                            <input type="text" class="form-control" value="{{ $child->section ?? 'Not Assigned' }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" value="{{ $child->status }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Age</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($child->created_at)->diffInYears(now()) + 5 }} years" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="dashboard-card">
                    <h3 class="mb-3">Academic Summary</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">92%</div>
                                <div class="label">Attendance Rate</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">A-</div>
                                <div class="label">Average Grade</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">85%</div>
                                <div class="label">Mathematics</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">87%</div>
                                <div class="label">Science</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Recent Activities</h3>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Today</td>
                                    <td>Attendance</td>
                                    <td>Present - 8:00 AM to 3:00 PM</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Yesterday</td>
                                    <td>Mathematics Test</td>
                                    <td>Grade: A (92%)</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>2 days ago</td>
                                    <td>Science Assignment</td>
                                    <td>Submitted on time</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('parent.attendance') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <i class="fas fa-calendar-check fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>View Attendance</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('parent.grades') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <i class="fas fa-chart-line fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>View Grades</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('parent.chats') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <i class="fas fa-comments fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Chat with Teachers</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('parent.messages') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <i class="fas fa-envelope fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>View Messages</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 