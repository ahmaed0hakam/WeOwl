@extends('layouts.app')

@section('title', 'Manage Classes - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.manager-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="welcome mb-4">Manage Classes</h2>
            </div>
        </div>
        
        <!-- Add New Class Button -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('manager.add-class') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Class
                </a>
            </div>
        </div>
        
        <!-- Classes List -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>All Classes</h3>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Teacher</th>
                                    <th>Subject</th>
                                    <th>Schedule</th>
                                    <th>Room</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\ClassRoom::with('teacher')->get() as $class)
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->teacher->name ?? 'Not Assigned' }}</td>
                                    <td>{{ $class->subject }}</td>
                                    <td>{{ $class->schedule }}</td>
                                    <td>{{ $class->room_number }}</td>
                                    <td>
                                        <a href="{{ route('manager.edit-class', $class->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('manager.view-class', $class->id) }}" class="btn btn-sm btn-info">
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
                    <div class="number">{{ \App\Models\ClassRoom::count() }}</div>
                    <div class="label">Total Classes</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="number">{{ \App\Models\Student::count() }}</div>
                    <div class="label">Total Students</div>
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
                    <div class="number">{{ \App\Models\ClassRoom::count() > 0 ? round(\App\Models\Student::count() / \App\Models\ClassRoom::count(), 1) : 0 }}</div>
                    <div class="label">Avg Students/Class</div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 