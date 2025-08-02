@extends('layouts.app')

@section('title', 'Add Student - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.manager-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="welcome mb-4">Add New Student</h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="dashboard-card">
                    <form method="POST" action="{{ route('manager.add-student.post') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="class_id" class="form-label">Class</label>
                                <select class="form-control" id="class_id" name="class_id" required>
                                    <option value="">Select Class</option>
                                    @foreach(\App\Models\ClassRoom::all() as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->subject }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="parent_id" class="form-label">Parent</label>
                                <select class="form-control" id="parent_id" name="parent_id" required>
                                    <option value="">Select Parent</option>
                                    @foreach(\App\Models\ParentUser::all() as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="section_id" class="form-label">Section</label>
                                <select class="form-control" id="section_id" name="section_id" required>
                                    <option value="">Select Section</option>
                                    @foreach(\App\Models\Section::all() as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 