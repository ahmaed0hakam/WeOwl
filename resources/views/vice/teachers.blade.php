@extends('layouts.app')

@section('title', 'Manage Teachers - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.vice-manager-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="welcome mb-4">Manage Teachers</h2>
            </div>
        </div>
        
        <!-- Add New Teacher Button -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('vice.add-user') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Teacher
                </a>
            </div>
        </div>
        
        <!-- Teachers List -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>All Teachers</h3>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Experience</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Teacher::all() as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->subject }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                    <td>{{ $teacher->experience_years ?? 0 }} years</td>
                                    <td>
                                        @if($teacher->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($teacher->status === 'on_leave')
                                            <span class="badge bg-warning">On Leave</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="row mt-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="number">{{ \App\Models\Teacher::count() }}</div>
                    <div class="label">Total Teachers</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="number">{{ \App\Models\Teacher::where('status', 'active')->count() }}</div>
                    <div class="label">Active Teachers</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="number">{{ \App\Models\Teacher::where('status', 'on_leave')->count() }}</div>
                    <div class="label">On Leave</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="number">{{ \App\Models\Teacher::avg('experience_years') ?? 0 }}</div>
                    <div class="label">Avg Years Experience</div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 