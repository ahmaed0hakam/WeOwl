@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.manage-classes') }}">Manage Classes</a></li>
                        <li class="breadcrumb-item active">View Class</li>
                    </ol>
                </div>
                <h4 class="page-title">Class Details: {{ $class->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Class Information</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Class Name:</strong></td>
                            <td>{{ $class->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Subject:</strong></td>
                            <td>{{ $class->subject }}</td>
                        </tr>
                        <tr>
                            <td><strong>Teacher:</strong></td>
                            <td>{{ $class->teacher->name ?? 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Schedule:</strong></td>
                            <td>{{ $class->schedule }}</td>
                        </tr>
                        <tr>
                            <td><strong>Room:</strong></td>
                            <td>{{ $class->room_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>Capacity:</strong></td>
                            <td>{{ $class->students->count() }}/{{ $class->capacity }}</td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong></td>
                            <td>{{ $class->description ?? 'No description' }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('manager.edit-class', $class->id) }}" class="btn btn-warning">Edit Class</a>
                        <form action="{{ route('manager.delete-class', $class->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this class?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Class</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Students ({{ $class->students->count() }})</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    @if($class->students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Section</th>
                                        <th>Parent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->students as $student)
                                        <tr>
                                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td>{{ $student->section }}</td>
                                            <td>{{ $student->parent->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <form action="{{ route('manager.remove-students', $class->id) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label>Select students to remove:</label>
                                <select name="student_ids[]" class="form-control" multiple>
                                    @foreach($class->students as $student)
                                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning btn-sm">Remove Selected</button>
                        </form>
                    @else
                        <p class="text-muted">No students assigned to this class.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($availableStudents->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Assign Students</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    <form action="{{ route('manager.assign-students', $class->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Select students to assign to this class:</label>
                            <select name="student_ids[]" class="form-control" multiple required>
                                @foreach($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->parent->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Selected Students</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 