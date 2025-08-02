@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.parents') }}">Parents</a></li>
                        <li class="breadcrumb-item active">View Parent</li>
                    </ol>
                </div>
                <h4 class="page-title">Parent Details: {{ $parent->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Parent Information</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $parent->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $parent->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Children Count:</strong></td>
                            <td>{{ $parent->students->count() ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($parent->students->count() > 0)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning">No Children</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('manager.edit-parent', $parent->id) }}" class="btn btn-warning">Edit Parent</a>
                        <a href="{{ route('manager.parents') }}" class="btn btn-secondary">Back to Parents</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">Children ({{ $parent->students->count() }})</h5>
                </div>
                <div class="card-body bg-dark text-white">
                    @if($parent->students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($parent->students as $student)
                                        <tr>
                                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td>{{ $student->class_name ?? 'Unassigned' }}</td>
                                            <td>{{ $student->section }}</td>
                                            <td>
                                                @if($student->class_id)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-warning">Unassigned</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No children registered for this parent.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 