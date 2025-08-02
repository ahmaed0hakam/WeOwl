@extends('layouts.app')

@section('title', 'Manage Grades - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Manage Student Grades</h2>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Add Grade Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Add New Grade</h3>
                    <form action="{{ route('teacher.add-grade') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="student_id" class="form-label">Student</label>
                                    <select class="form-control" name="student_id" required>
                                        <option value="">Select Student</option>
                                        @foreach($classes as $class)
                                            @foreach($class->students as $student)
                                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} ({{ $class->name }})</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" name="subject" placeholder="e.g., Mathematics" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="grade" class="form-label">Grade</label>
                                    <select class="form-control" name="grade" required>
                                        <option value="">Select Grade</option>
                                        <option value="A+">A+</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="C-">C-</option>
                                        <option value="D+">D+</option>
                                        <option value="D">D</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="percentage" class="form-label">Percentage</label>
                                    <input type="number" class="form-control" name="percentage" min="0" max="100" placeholder="85" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="comments" class="form-label">Comments</label>
                                    <textarea class="form-control" name="comments" placeholder="Optional comments" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Grade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Grades Overview -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Grades Overview</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Percentage</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grades = \App\Models\Grade::with(['student', 'teacher'])
                                        ->where('teacher_id', session('teacher_id'))
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                @endphp
                                
                                @forelse($grades as $grade)
                                <tr>
                                    <td>
                                        <strong>{{ $grade->student->first_name }} {{ $grade->student->last_name }}</strong>
                                    </td>
                                    <td>{{ $grade->student->class_name ?? 'N/A' }}</td>
                                    <td>{{ $grade->subject }}</td>
                                    <td>
                                        <span class="badge bg-{{ $grade->grade == 'A' || $grade->grade == 'A+' ? 'success' : ($grade->grade == 'F' ? 'danger' : 'warning') }}">
                                            {{ $grade->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->percentage }}%</td>
                                    <td>{{ $grade->comments ?? '-' }}</td>
                                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                        <p>No grades added yet. Start by adding grades for your students.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 