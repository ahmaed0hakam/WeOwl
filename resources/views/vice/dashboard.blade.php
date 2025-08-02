@extends('layouts.app')

@section('title', 'Vice Manager Dashboard - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.vice-manager-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="welcome mb-4">Vice Manager Dashboard</h2>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#studentsModal">
                    <div class="number">{{ $totalStudents ?? 150 }}</div>
                    <div class="label">Total Students</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#teachersModal">
                    <div class="number">{{ $totalTeachers ?? 12 }}</div>
                    <div class="label">Total Teachers</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#classesModal">
                    <div class="number">{{ $totalClasses ?? 8 }}</div>
                    <div class="label">Total Classes</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                    <div class="number">{{ $attendanceRate ?? '88%' }}</div>
                    <div class="label">Overall Attendance</div>
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
                            <a href="{{ route('vice.classes') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-school fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Manage Classes</h5>
                                    <p class="text-muted">View and manage classes</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('vice.teachers') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-chalkboard-teacher fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Manage Teachers</h5>
                                    <p class="text-muted">View and manage teachers</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('vice.add-user') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-user-plus fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Add User</h5>
                                    <p class="text-muted">Add new users to system</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('vice.attendance-reports') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-chart-bar fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Attendance Reports</h5>
                                    <p class="text-muted">View attendance reports</p>
                                </div>
                            </a>
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
                                    <th>Activity</th>
                                    <th>User</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>New teacher added</td>
                                    <td>Sarah Johnson</td>
                                    <td>Today</td>
                                </tr>
                                <tr>
                                    <td>Class created</td>
                                    <td>Class 5A</td>
                                    <td>Yesterday</td>
                                </tr>
                                <tr>
                                    <td>Attendance report generated</td>
                                    <td>Monthly Report</td>
                                    <td>2 days ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Modal -->
    <div class="modal fade" id="studentsModal" tabindex="-1" aria-labelledby="studentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentsModalLabel">All Students</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Parent</th>
                                    <th>Attendance</th>
                                    <th>Average Grade</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe Jr.</td>
                                    <td>Class 1A</td>
                                    <td>John Parent</td>
                                    <td>95%</td>
                                    <td>A-</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>Class 1B</td>
                                    <td>Jane Parent</td>
                                    <td>88%</td>
                                    <td>B+</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mike Johnson</td>
                                    <td>Class 2A</td>
                                    <td>Mike Parent</td>
                                    <td>92%</td>
                                    <td>A</td>
                                    <td><span class="badge bg-warning">On Leave</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Add New Student</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Modal -->
    <div class="modal fade" id="teachersModal" tabindex="-1" aria-labelledby="teachersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="teachersModalLabel">All Teachers</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Experience</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Teacher::all() as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->subject }}</td>
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
                                        <button class="btn btn-sm btn-info">View</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('vice.teachers') }}" class="btn btn-primary">Manage Teachers</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes Modal -->
    <div class="modal fade" id="classesModal" tabindex="-1" aria-labelledby="classesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="classesModalLabel">All Classes</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Teacher</th>
                                    <th>Subject</th>
                                    <th>Schedule</th>
                                    <th>Room</th>
                                    <th>Students</th>
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
                                    <td>{{ $class->students->count() ?? 0 }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('vice.classes') }}" class="btn btn-primary">Manage Classes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance Overview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Teacher</th>
                                    <th>Total Students</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Rate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Class 1A</td>
                                    <td>Sarah Teacher</td>
                                    <td>25</td>
                                    <td>23</td>
                                    <td>2</td>
                                    <td>92%</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View Details</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Class 1B</td>
                                    <td>Mike Teacher</td>
                                    <td>23</td>
                                    <td>21</td>
                                    <td>2</td>
                                    <td>91%</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View Details</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Class 2A</td>
                                    <td>Lisa Teacher</td>
                                    <td>28</td>
                                    <td>26</td>
                                    <td>2</td>
                                    <td>93%</td>
                                    <td>
                                        <button class="btn btn-sm btn-info">View Details</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('vice.attendance-reports') }}" class="btn btn-primary">View Full Reports</a>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 