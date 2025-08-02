@extends('layouts.app')

@section('title', 'WeOwl - School Management System')

@section('content')
<div class="welcome-container">
    <header>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('images/WeOwl.png') }}" alt="WeOwl" width="50px" /> WeOwl
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navmenu"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navmenu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="#about" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="#features" class="nav-link">Features</a>
                        </li>
                        <li class="nav-item">
                            <a href="#why-us" class="nav-link">Why Us</a>
                        </li>
                        <li class="nav-item">
                            <div class="" id="navbarNavDarkDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a
                                            class="nav-link dropdown-toggle"
                                            href="#"
                                            role="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            Login
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('parent.login') }}">As Parent</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('teacher.login') }}">As Teacher</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('manager.login') }}">As Manager</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('vice.login') }}">As ViceManager</a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('register.parent') }}">Register as Parent</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('register.teacher') }}">Register as Teacher</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="welcome-content">
        <!-- Hero Section -->
        <section class="section first-section" id="about">
            <video autoplay muted loop id="myVideo">
                <source src="{{ asset('images/girl.mp4') }}" type="video/mp4" />
            </video>
            <div class="hero-content">
                <h1 class="hero-title">
                    <span class="welcome">Welcome</span> to WeOwl!
                </h1>
                <h3 class="hero-subtitle">The best platform to follow up with your child's information at school</h3>
                <div class="hero-buttons">
                    <a href="{{ route('register.parent') }}" class="btn btn-primary btn-lg me-3">Register as Parent</a>
                    <a href="{{ route('register.teacher') }}" class="btn btn-outline-light btn-lg">Register as Teacher</a>
                </div>
            </div>
            
            <div class="content">
                <div class="box">
                    <div class="content-show">
                        <h4>What is WeOwl?</h4>
                    </div>
                    <div class="content-hide">
                        <p>
                            A comprehensive school management system specially designed for parents to follow up with their
                            children's information at school in real-time.
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="content-show">
                        <h4>What classes does it cover?</h4>
                    </div>
                    <div class="content-hide">
                        <p>
                            WeOwl is specially designed for elementary school students, because
                            they are the builders of the future, and we must pay special
                            attention to them.
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="content-show">
                        <h4>Should you use WeOwl?</h4>
                    </div>
                    <div class="content-hide">
                        <p>
                            Of course you should!
                            Your child needs it, you need it. Stay connected with your child's education journey.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="section second-section" id="features">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title">Our Features</h2>
                        <hr class="section-divider" />
                        <p class="section-subtitle">Everything you need to stay connected with your child's education</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h4>Attendance Tracking</h4>
                            <p>Real-time notifications when your child arrives and leaves school</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4>Academic Progress</h4>
                            <p>Track exams, activities, tasks, and overall academic performance</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h4>Communication</h4>
                            <p>Direct communication with teachers and school administration</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h4>Student Data</h4>
                            <p>Complete access to your child's personal and academic information</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Us Section -->
        <section class="section second-section" id="why-us">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title">Why Choose WeOwl?</h2>
                        <hr class="section-divider" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="why-us-card">
                            <h4>Jordan's First School Management System</h4>
                            <p>
                                This website is the first of its kind in Jordan, made by Jordanian
                                graduates at
                                <a href="https://www.just.edu.jo/Pages/Default.aspx">Jordan University of Science and Technology</a>. 
                                Our innovative approach brings modern technology to education management.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <h5>Attendance</h5>
                                    <p>Parents receive notifications when their children arrive at and when they leave school.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <h5>Academics</h5>
                                    <p>Parents can keep abreast of everything new, such as their child's exams, activities and tasks.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <h5>Communication</h5>
                                    <p>Parents able to see teachers communication info and keep in touch with them.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <h5>Student Data</h5>
                                    <p>Parents able to see their children's data, such as courses and their info, personal details and etc.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

@include('layouts.partials.footer')
@endsection
