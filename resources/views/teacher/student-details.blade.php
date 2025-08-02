@extends('layouts.app')

@section('title', 'Student Details - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Student Details</h2>
                    <div>
                        <a href="{{ route('teacher.view-class', $student->classRoom->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Class
                        </a>
                        <a href="{{ route('teacher.grades') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Grade
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Student Information -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3>{{ $student->first_name }} {{ $student->last_name }}</h3>
                            <p class="text-muted mb-0">Student ID: {{ $student->id }}</p>
                        </div>
                        <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'secondary' }} fs-6">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Class:</strong></td>
                                    <td>{{ $student->classRoom->name ?? 'Not assigned' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Section:</strong></td>
                                    <td>{{ $student->section ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Parent:</strong></td>
                                    <td>{{ $student->parent->name ?? 'Not assigned' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Parent Email:</strong></td>
                                    <td>{{ $student->parent->email ?? 'Not available' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Academic Summary</h5>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-card">
                                        <div class="stat-number">{{ $recentGrades->count() }}</div>
                                        <div class="stat-label">Grades</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-card">
                                        <div class="stat-number">{{ $attendancePercentage }}%</div>
                                        <div class="stat-label">Attendance</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-card">
                                        <div class="stat-number">{{ $averageGrade ? round($averageGrade, 1) : 'N/A' }}</div>
                                        <div class="stat-label">Avg Grade</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h4>Quick Actions</h4>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="addGrade({{ $student->id }})">
                            <i class="fas fa-plus"></i> Add Grade
                        </button>
                        <button class="btn btn-success" onclick="markAttendance({{ $student->id }})">
                            <i class="fas fa-calendar-check"></i> Mark Attendance
                        </button>
                        <button class="btn btn-info" onclick="sendMessage({{ $student->parent->id ?? 0 }})">
                            <i class="fas fa-comments"></i> Message Parent
                        </button>
                        <a href="{{ route('teacher.attendance') }}" class="btn btn-warning">
                            <i class="fas fa-list"></i> View All Attendance
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Grades -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Recent Grades</h3>
                        <button class="btn btn-sm btn-primary" onclick="addGrade({{ $student->id }})">
                            <i class="fas fa-plus"></i> Add New Grade
                        </button>
                    </div>
                    
                    @if($recentGrades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Percentage</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentGrades as $grade)
                                <tr>
                                    <td><strong>{{ $grade->subject }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $grade->grade == 'A' || $grade->grade == 'A+' ? 'success' : ($grade->grade == 'F' ? 'danger' : 'warning') }}">
                                            {{ $grade->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->percentage }}%</td>
                                    <td>{{ $grade->comments ?? '-' }}</td>
                                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewGrade({{ $grade->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editGrade({{ $grade->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted">
                        <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                        <p>No grades recorded yet for this student.</p>
                        <button class="btn btn-primary" onclick="addGrade({{ $student->id }})">
                            <i class="fas fa-plus"></i> Add First Grade
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Attendance Summary -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Attendance Summary</h3>
                    @if($attendanceSummary->count() > 0)
                    <div class="row text-center">
                        @foreach($attendanceSummary as $summary)
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">{{ $summary->count }}</div>
                                <div class="stat-label">{{ ucfirst($summary->status) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ $attendancePercentage }}%">
                                {{ $attendancePercentage }}%
                            </div>
                        </div>
                        <small class="text-muted">Attendance Rate</small>
                    </div>
                    @else
                    <div class="text-center text-muted">
                        <i class="fas fa-calendar-check fa-3x mb-3"></i>
                        <p>No attendance records yet.</p>
                        <button class="btn btn-success" onclick="markAttendance({{ $student->id }})">
                            <i class="fas fa-plus"></i> Mark Attendance
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3>Performance Analytics</h3>
                    <div class="analytics-grid">
                        <div class="analytics-item">
                            <div class="analytics-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="analytics-number">{{ $averageGrade ? round($averageGrade, 1) : 'N/A' }}%</div>
                                <div class="analytics-label">Average Grade</div>
                            </div>
                        </div>
                        
                        <div class="analytics-item">
                            <div class="analytics-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="analytics-number">{{ $recentGrades->count() }}</div>
                                <div class="analytics-label">Total Grades</div>
                            </div>
                        </div>
                        
                        <div class="analytics-item">
                            <div class="analytics-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="analytics-number">{{ $student->created_at->diffForHumans() }}</div>
                                <div class="analytics-label">Enrolled</div>
                            </div>
                        </div>
                        
                        <div class="analytics-item">
                            <div class="analytics-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="analytics-number">{{ $recentGrades->where('grade', 'A')->count() + $recentGrades->where('grade', 'A+')->count() }}</div>
                                <div class="analytics-label">A Grades</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Grade for {{ $student->first_name }} {{ $student->last_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('teacher.add-grade') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="student_id" id="gradeStudentId" value="{{ $student->id }}">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="percentage" class="form-label">Percentage</label>
                                    <input type="number" class="form-control" name="percentage" min="0" max="100" required>
                                </div>
                            </div>
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
    
    <!-- Mark Attendance Modal -->
    <div class="modal fade" id="markAttendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark Attendance for {{ $student->first_name }} {{ $student->last_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('teacher.mark-attendance') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="student_id" id="attendanceStudentId" value="{{ $student->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="time_in" class="form-label">Time In</label>
                                    <input type="time" class="form-control" name="time_in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="time_out" class="form-label">Time Out</label>
                                    <input type="time" class="form-control" name="time_out">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Mark Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <style>
        .stat-card {
            background: rgba(52, 58, 64, 0.3);
            border: 1px solid rgba(245, 177, 112, 0.2);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #f5b170;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .analytics-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: rgba(52, 58, 64, 0.3);
            border-radius: 8px;
            border: 1px solid rgba(245, 177, 112, 0.2);
        }
        
        .analytics-icon {
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
        
        .analytics-content {
            flex: 1;
        }
        
        .analytics-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 2px;
        }
        
        .analytics-label {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .progress {
            height: 8px;
            background: rgba(52, 58, 64, 0.5);
        }
        
        .progress-bar {
            background: linear-gradient(135deg, #f5b170, #e67e22);
        }
    </style>
    
    <script>
        function addGrade(studentId) {
            document.getElementById('gradeStudentId').value = studentId;
            new bootstrap.Modal(document.getElementById('addGradeModal')).show();
        }
        
        function markAttendance(studentId) {
            document.getElementById('attendanceStudentId').value = studentId;
            new bootstrap.Modal(document.getElementById('markAttendanceModal')).show();
        }
        
        function sendMessage(parentId) {
            if (parentId > 0) {
                window.location.href = "{{ route('teacher.chats') }}";
            } else {
                alert('No parent assigned to this student.');
            }
        }
        
        function viewGrade(gradeId) {
            // Implement grade details view
            alert('Grade details functionality would be implemented here');
        }
        
        function editGrade(gradeId) {
            // Implement grade editing
            alert('Grade editing functionality would be implemented here');
        }
    </script>
    
    @include('layouts.partials.footer')
</div>
@endsection 