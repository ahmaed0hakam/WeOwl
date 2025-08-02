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
                        <li class="breadcrumb-item active">Edit Class</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Class: {{ $class->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-dark text-white">
                    <form action="{{ route('manager.edit-class.post', $class->id) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Class Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $class->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="teacher_id" class="form-label">Teacher</label>
                                <select class="form-control" id="teacher_id" name="teacher_id" required>
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }} ({{ $teacher->subject }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ $class->subject }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="schedule" class="form-label">Schedule</label>
                                <input type="text" class="form-control" id="schedule" name="schedule" value="{{ $class->schedule }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="room_number" class="form-label">Room Number</label>
                                <input type="text" class="form-control" id="room_number" name="room_number" value="{{ $class->room_number }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" min="1" max="100" value="{{ $class->capacity }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $class->description }}</textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Class</button>
                                <a href="{{ route('manager.manage-classes') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 