@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Parents</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Parents</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title">All Parents</h5>
                    <a href="{{ route('manager.add-parent') }}" class="btn btn-primary">Add New Parent</a>
                </div>
                <div class="card-body bg-dark text-white">
                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                @foreach($parents as $parent)
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
                                        <a href="{{ route('manager.view-parent', $parent->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('manager.edit-parent', $parent->id) }}" class="btn btn-sm btn-warning">Edit</a>
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