@extends('layouts.app')

@section('title', 'Teacher Login - WeOwl')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-card">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/WeOwl.png') }}" alt="WeOwl" width="80px" class="mb-3" />
                        <h2 class="welcome">Teacher Login</h2>
                        <p class="text-muted">Welcome to WeOwl School Management System</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('teacher.login.post') }}">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required 
                                class="form-control"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                            >
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                class="form-control"
                                placeholder="Enter your password"
                            >
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember" 
                                    class="form-check-input"
                                >
                                <label for="remember" class="form-check-label">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button 
                                type="submit" 
                                class="btn btn-primary"
                            >
                                Sign In
                            </button>
                        </div>
                    </form>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <p>Don't have an account? <a href="{{ route('register.teacher') }}" class="text-decoration-none">Register here</a></p>
                        <a href="{{ route('welcome') }}" class="text-decoration-none">
                            ← Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 