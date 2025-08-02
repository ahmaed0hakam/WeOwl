@extends('layouts.app')

@section('title', 'Class Details - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Class Details</h2>
                    <a href="{{ route('teacher.classes') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Classes
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Class Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Class Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Class Name:</strong> {{ $class->name }}</p>
                            <p><strong>Subject:</strong> {{ $class->subject }}</p>
                            <p><strong>Teacher:</strong> {{ $class->teacher->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Students:</strong> {{ $class->students->count() }}</p>
                            <p><strong>Class Schedule:</strong> {{ $class->schedule ?? 'Not specified' }}</p>
                            <p><strong>Room:</strong> {{ $class->room ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="d-grid gap-2">
                        <a href="{{ route('teacher.grades') }}" class="btn btn-primary">
                            <i class="fas fa-graduation-cap"></i> Manage Grades
                        </a>
                        <a href="{{ route('teacher.attendance') }}" class="btn btn-success">
                            <i class="fas fa-calendar-check"></i> Mark Attendance
                        </a>
                        <a href="{{ route('teacher.chats') }}" class="btn btn-info">
                            <i class="fas fa-comments"></i> Chat with Parents
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Students List -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Students in this Class</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Parent</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($class->students as $student)
                                <tr>
                                    <td>
                                        <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                                    </td>
                                    <td>
                                        @if($student->parent)
                                            {{ $student->parent->name }}
                                        @else
                                            <span class="text-muted">No parent assigned</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->section ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" onclick="viewStudentDetails({{ $student->id }})">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" onclick="addGrade({{ $student->id }})">
                                                <i class="fas fa-plus"></i> Add Grade
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <p>No students assigned to this class yet.</p>
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
    
    <!-- Student Details Modal -->
    <div class="modal fade" id="studentDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="studentDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('teacher.add-grade') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="student_id" id="gradeStudentId">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
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
                        <div class="mb-3">
                            <label for="percentage" class="form-label">Percentage</label>
                            <input type="number" class="form-control" name="percentage" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea class="form-control" name="comments" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function viewStudentDetails(studentId) {
            window.location.href = `/teacher/student/${studentId}`;
        }
        
        function addGrade(studentId) {
            document.getElementById('gradeStudentId').value = studentId;
            new bootstrap.Modal(document.getElementById('addGradeModal')).show();
        }
    </script>
    
    @include('layouts.partials.footer')
</div>
@endsection 