@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Teachers</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Teachers</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">All Teachers</h5>
                    <a href="{{ route('manager.add-teacher') }}" class="btn btn-primary">Add New Teacher</a>
                </div>
                <div class="card-body bg-dark text-white">
                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                @foreach($teachers as $teacher)
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
                                        <a href="{{ route('manager.view-teacher', $teacher->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('manager.edit-teacher', $teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
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