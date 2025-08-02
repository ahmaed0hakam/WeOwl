@extends('layouts.app')

@section('title', 'Manager Dashboard - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.manager-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="welcome mb-4">Manager Dashboard</h2>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#studentsModal">
                    <div class="number">{{ $totalStudents ?? 0 }}</div>
                    <div class="label">Total Students</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#teachersModal">
                    <div class="number">{{ $totalTeachers ?? 0 }}</div>
                    <div class="label">Total Teachers</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#classesModal">
                    <div class="number">{{ $totalClasses ?? 0 }}</div>
                    <div class="label">Total Classes</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#parentsModal">
                    <div class="number">{{ $totalParents ?? 0 }}</div>
                    <div class="label">Total Parents</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('manager.add-student') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-user-plus fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Add Student</h5>
                                    <p class="text-muted">Register new students</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('manager.students') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-users fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Manage Students</h5>
                                    <p class="text-muted">View and edit students</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('manager.add-teacher') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-chalkboard-teacher fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Add Teacher</h5>
                                    <p class="text-muted">Hire new teachers</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('manager.teachers') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-user-tie fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Manage Teachers</h5>
                                    <p class="text-muted">View and edit teachers</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('manager.manage-classes') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-school fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Manage Classes</h5>
                                    <p class="text-muted">View and manage classes</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('manager.parents') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-users fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Manage Parents</h5>
                                    <p class="text-muted">View and manage parents</p>
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
                                    <td>Sarah Teacher</td>
                                    <td>Today</td>
                                </tr>
                                <tr>
                                    <td>Class created</td>
                                    <td>Class 1A</td>
                                    <td>Yesterday</td>
                                </tr>
                                <tr>
                                    <td>Student registered</td>
                                    <td>John Doe</td>
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
                                    <th>Section</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Student::with(['classRoom', 'parent'])->get() as $student)
                                <tr>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->class_name ?? 'Unassigned' }}</td>
                                    <td>{{ $student->section }}</td>
                                    <td>{{ $student->parent->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($student->class_id)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('manager.view-class', $student->class_id) }}" class="btn btn-sm btn-info">View Class</a>
                                        <a href="{{ route('manager.edit-class', $student->class_id) }}" class="btn btn-sm btn-warning">Edit Class</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('manager.add-student') }}" class="btn btn-primary">Add New Student</a>
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
                                        <a href="{{ route('manager.view-teacher', $teacher->id) }}" class="btn btn-sm btn-info">View Profile</a>
                                        <a href="{{ route('manager.edit-teacher', $teacher->id) }}" class="btn btn-sm btn-warning">Edit Profile</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('manager.add-teacher') }}" class="btn btn-primary">Add New Teacher</a>
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
                                        <a href="{{ route('manager.view-class', $class->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('manager.edit-class', $class->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            </div>
                        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('manager.manage-classes') }}" class="btn btn-primary">Manage Classes</a>
                                </div>
                            </div>
                            </div>
                        </div>

    <!-- Parents Modal -->
    <div class="modal fade" id="parentsModal" tabindex="-1" aria-labelledby="parentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="parentsModalLabel">All Parents</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Children</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\ParentUser::with('students')->get() as $parent)
                                <tr>
                                    <td>{{ $parent->name }}</td>
                                    <td>{{ $parent->email }}</td>
                                    <td>{{ $parent->students->count() ?? 0 }}</td>
                                    <td>
                                        @if($parent->students->count() > 0)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">No Children</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('manager.view-parent', $parent->id) }}" class="btn btn-sm btn-info">View Profile</a>
                                        <a href="{{ route('manager.edit-parent', $parent->id) }}" class="btn btn-sm btn-warning">Edit Profile</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('manager.add-parent') }}" class="btn btn-primary">Add New Parent</a>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 