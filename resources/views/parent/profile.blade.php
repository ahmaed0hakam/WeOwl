@extends('layouts.app')

@section('title', 'Parent Profile - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">My Profile</h2>
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="dashboard-card">
                    <h3 class="mb-4">Profile Information</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('parent.update-profile') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $parent->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $parent->email }}" required>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h4 class="mb-3">Change Password (Optional)</h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <small class="text-muted">Leave blank if you don't want to change password</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Account Created</label>
                                <input type="text" class="form-control" value="{{ $parent->created_at->format('M d, Y') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Updated</label>
                                <input type="text" class="form-control" value="{{ $parent->updated_at->format('M d, Y') }}" readonly>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Account Statistics -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Account Statistics</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ $parent->students()->count() }}</div>
                                <div class="label">Children</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ \App\Models\Notification::where('recipient_id', $parent->id)->where('recipient_type', 'parent')->count() }}</div>
                                <div class="label">Total Messages</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ \App\Models\Notification::where('recipient_id', $parent->id)->where('recipient_type', 'parent')->where('is_read', false)->count() }}</div>
                                <div class="label">Unread Messages</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ \Carbon\Carbon::parse($parent->created_at)->diffInDays(now()) }}</div>
                                <div class="label">Days Active</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.partials.footer')
</div>
@endsection 