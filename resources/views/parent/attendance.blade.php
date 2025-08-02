@extends('layouts.app')

@section('title', 'Attendance - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Attendance Records</h2>
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
                            <div class="stats-card text-center" onclick="filterByChild('{{ $child->first_name }} {{ $child->last_name }}')" style="cursor: pointer;">
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
        
        <!-- Attendance Table -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Attendance History</h3>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Child</th>
                                    <th>Status</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $record)
                                <tr class="attendance-row" data-child="{{ $record['child_name'] }}">
                                    <td>{{ $record['date'] }}</td>
                                    <td>
                                        <strong>{{ $record['child_name'] }}</strong>
                                        @foreach($children as $child)
                                            @if($child->first_name . ' ' . $child->last_name == $record['child_name'])
                                                <br><small class="text-muted">{{ $child->class_name ?? 'Not Assigned' }}</small>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($record['status'] == 'Present') bg-success
                                            @elseif($record['status'] == 'Late') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ $record['status'] }}
                                        </span>
                                    </td>
                                    <td>{{ $record['time_in'] }}</td>
                                    <td>{{ $record['time_out'] }}</td>
                                    <td>{{ $record['notes'] }}</td>
                                </tr>
                                @endforeach
                                @if(count($attendance) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No attendance records available</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Attendance Summary -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Attendance Summary</h3>
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
                                                <div class="number">92%</div>
                                                <div class="label">Attendance Rate</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">15</div>
                                                <div class="label">Days Present</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">1</div>
                                                <div class="label">Late Days</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">0</div>
                                                <div class="label">Absent Days</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="stats-card text-center">
                                                <div class="number">16</div>
                                                <div class="label">Total Days</div>
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
            const rows = document.querySelectorAll('.attendance-row');
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