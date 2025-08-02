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
                        <li class="breadcrumb-item active">Edit Teacher</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Teacher: {{ $teacher->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body bg-dark text-white">
                    <form method="POST" action="{{ route('manager.edit-teacher.post', $teacher->id) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $teacher->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $teacher->email }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ $teacher->subject }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="experience_years" class="form-label">Experience (Years)</label>
                                <input type="number" class="form-control" id="experience_years" name="experience_years" value="{{ $teacher->experience_years ?? 0 }}" min="0" max="50">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="qualification" class="form-label">Qualification</label>
                                <input type="text" class="form-control" id="qualification" name="qualification" value="{{ $teacher->qualification }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $teacher->phone }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ $teacher->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="on_leave" {{ $teacher->status === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="inactive" {{ $teacher->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ $teacher->address }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('manager.teachers') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Teacher</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 