@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.teachers') }}">Teachers</a></li>
                        <li class="breadcrumb-item active">View Teacher</li>
                    </ol>
                </div>
                <h4 class="page-title">Teacher Details: {{ $teacher->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Teacher Information</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $teacher->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $teacher->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Subject:</strong></td>
                            <td>{{ $teacher->subject }}</td>
                        </tr>
                        <tr>
                            <td><strong>Experience:</strong></td>
                            <td>{{ $teacher->experience_years ?? 0 }} years</td>
                        </tr>
                        <tr>
                            <td><strong>Qualification:</strong></td>
                            <td>{{ $teacher->qualification ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $teacher->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $teacher->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($teacher->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($teacher->status === 'on_leave')
                                    <span class="badge bg-warning">On Leave</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('manager.edit-teacher', $teacher->id) }}" class="btn btn-warning">Edit Teacher</a>
                        <a href="{{ route('manager.teachers') }}" class="btn btn-secondary">Back to Teachers</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Classes Taught ({{ $classes->count() }})</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    @if($classes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Subject</th>
                                        <th>Students</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classes as $class)
                                        <tr>
                                            <td>{{ $class->name }}</td>
                                            <td>{{ $class->subject }}</td>
                                            <td>{{ $class->students->count() ?? 0 }}</td>
                                            <td>
                                                <a href="{{ route('manager.view-class', $class->id) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No classes assigned to this teacher.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 