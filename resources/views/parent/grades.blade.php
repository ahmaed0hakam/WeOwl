@extends('layouts.app')

@section('title', 'Student Grades - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Student Grades</h2>
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Children Filter -->
        @if($children->count() > 1)
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Select Child</h3>
                    <div class="row">
                        @foreach($children as $child)
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center" onclick="filterByChild('{{ $child->id }}')" style="cursor: pointer;">
                                <i class="fas fa-user-graduate fa-2x mb-2" style="color: #f5b170;"></i>
                                <h5>{{ $child->first_name }} {{ $child->last_name }}</h5>
                                <p class="text-muted">{{ $child->class_name ?? 'Not Assigned' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Grades Table -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Academic Performance</h3>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Child</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Percentage</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grades as $grade)
                                <tr class="grade-row" data-child="{{ $grade['child_name'] }}">
                                    <td>
                                        <strong>{{ $grade['child_name'] }}</strong>
                                        @foreach($children as $child)
                                            @if($child->first_name . ' ' . $child->last_name == $grade['child_name'])
                                                <br><small class="text-muted">{{ $child->class_name ?? 'Not Assigned' }}</small>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $grade['subject'] }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($grade['grade'] == 'A' || $grade['grade'] == 'A+') bg-success
                                            @elseif($grade['grade'] == 'B' || $grade['grade'] == 'B+') bg-info
                                            @elseif($grade['grade'] == 'C' || $grade['grade'] == 'C+') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ $grade['grade'] }}
                                        </span>
                                    </td>
                                    <td>{{ $grade['percentage'] }}</td>
                                    <td>{{ $grade['comments'] }}</td>
                                    <td>{{ \Carbon\Carbon::now()->subDays(rand(1, 30))->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                                @if(count($grades) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No grades available</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Grade Summary -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Grade Summary</h3>
                    <div class="row">
                        @foreach($children as $child)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    <h5>{{ $child->first_name }} {{ $child->last_name }}</h5>
                                </div>
                                <div class="card-body bg-dark text-white">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">A-</div>
                                                <div class="label">Average Grade</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">89%</div>
                                                <div class="label">Overall Percentage</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">A</div>
                                                <div class="label">Mathematics</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">B+</div>
                                                <div class="label">Science</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">A-</div>
                                                <div class="label">English</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function filterByChild(childName) {
            const rows = document.querySelectorAll('.grade-row');
            rows.forEach(row => {
                if (childName === 'all' || row.getAttribute('data-child').includes(childName)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    
    @include('layouts.partials.footer')
</div>
@endsection 