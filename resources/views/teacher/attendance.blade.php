@extends('layouts.app')

@section('title', 'Mark Attendance - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Mark Student Attendance</h2>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Mark Attendance Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Mark Attendance</h3>
                    <form action="{{ route('teacher.mark-attendance') }}" method="POST">
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
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="time_in" class="form-label">Time In</label>
                                    <input type="time" class="form-control" name="time_in">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="time_out" class="form-label">Time Out</label>
                                    <input type="time" class="form-control" name="time_out">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" placeholder="Optional notes" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Mark Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Attendance Overview -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Attendance Overview</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Class</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $attendance = \App\Models\Attendance::with(['student', 'teacher'])
                                        ->where('teacher_id', session('teacher_id'))
                                        ->orderBy('date', 'desc')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                @endphp
                                
                                @forelse($attendance as $record)
                                <tr>
                                    <td>
                                        <strong>{{ $record->student->first_name }} {{ $record->student->last_name }}</strong>
                                    </td>
                                    <td>{{ $record->student->class_name ?? 'N/A' }}</td>
                                    <td>{{ $record->date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $record->status == 'present' ? 'success' : ($record->status == 'absent' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $record->time_in ?? '-' }}</td>
                                    <td>{{ $record->time_out ?? '-' }}</td>
                                    <td>{{ $record->notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-calendar-check fa-3x mb-3"></i>
                                        <p>No attendance records yet. Start marking attendance for your students.</p>
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