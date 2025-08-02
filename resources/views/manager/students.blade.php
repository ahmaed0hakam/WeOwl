@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Students</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Students</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">All Students</h5>
                    <a href="{{ route('manager.add-student') }}" class="btn btn-primary">Add New Student</a>
                </div>
                <div class="card-body bg-dark text-white">
                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                @foreach($students as $student)
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
                                        <a href="{{ route('manager.view-student', $student->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('manager.edit-student', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 