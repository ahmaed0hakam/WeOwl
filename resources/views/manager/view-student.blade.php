@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.students') }}">Students</a></li>
                        <li class="breadcrumb-item active">View Student</li>
                    </ol>
                </div>
                <h4 class="page-title">Student Details: {{ $student->first_name }} {{ $student->last_name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Student Information</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Class:</strong></td>
                            <td>{{ $student->class_name ?? 'Unassigned' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Section:</strong></td>
                            <td>{{ $student->section }}</td>
                        </tr>
                        <tr>
                            <td><strong>Parent:</strong></td>
                            <td>{{ $student->parent->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($student->class_id)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning">Unassigned</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('manager.edit-student', $student->id) }}" class="btn btn-warning">Edit Student</a>
                        <a href="{{ route('manager.students') }}" class="btn btn-secondary">Back to Students</a>
                    </div>
                </div>
            </div>
        </div>

        @if($student->classRoom)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Class Information</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Class Name:</strong></td>
                            <td>{{ $student->classRoom->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Subject:</strong></td>
                            <td>{{ $student->classRoom->subject }}</td>
                        </tr>
                        <tr>
                            <td><strong>Teacher:</strong></td>
                            <td>{{ $student->classRoom->teacher->name ?? 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Schedule:</strong></td>
                            <td>{{ $student->classRoom->schedule }}</td>
                        </tr>
                        <tr>
                            <td><strong>Room:</strong></td>
                            <td>{{ $student->classRoom->room_number }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('manager.view-class', $student->classRoom->id) }}" class="btn btn-info">View Class Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 