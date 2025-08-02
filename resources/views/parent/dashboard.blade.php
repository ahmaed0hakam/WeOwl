@extends('layouts.app')

@section('title', 'Parent Dashboard - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="welcome mb-4">Parent Dashboard</h2>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#childrenModal">
                    <div class="number">{{ $childrenCount ?? 0 }}</div>
                    <div class="label">My Children</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                    <div class="number">{{ $attendanceRate ?? '85%' }}</div>
                    <div class="label">Attendance Rate</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#gradesModal">
                    <div class="number">{{ $averageGrade ?? 'A-' }}</div>
                    <div class="label">Average Grade</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#messagesModal">
                    <div class="number">{{ $unreadMessages ?? 3 }}</div>
                    <div class="label">Unread Messages</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('parent.attendance') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-calendar-check fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>View Attendance</h5>
                                    <p class="text-muted">Check your child's attendance</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('parent.grades') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-chart-line fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>View Grades</h5>
                                    <p class="text-muted">Check academic performance</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('parent.chats') }}" class="text-decoration-none">
                                <div class="stats-card">
                                    <i class="fas fa-comments fa-2x mb-2" style="color: #f5b170;"></i>
                                    <h5>Chat with Teachers</h5>
                                    <p class="text-muted">Communicate with teachers</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Recent Activities</h3>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Child</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Attendance marked</td>
                                    <td>John Doe</td>
                                    <td>Today</td>
                                </tr>
                                <tr>
                                    <td>Grade updated</td>
                                    <td>John Doe</td>
                                    <td>Yesterday</td>
                                </tr>
                                <tr>
                                    <td>Message received</td>
                                    <td>John Doe</td>
                                    <td>2 days ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Children Modal -->
    <div class="modal fade" id="childrenModal" tabindex="-1" aria-labelledby="childrenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="childrenModalLabel">My Children</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Age</th>
                                    <th>Attendance</th>
                                    <th>Average Grade</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($children as $child)
                                <tr>
                                    <td>{{ $child->first_name }} {{ $child->last_name }}</td>
                                    <td>{{ $child->class_name ?? 'Not Assigned' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($child->created_at)->diffInYears(now()) + 5 }}</td>
                                    <td>92%</td>
                                    <td>A-</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <a href="{{ route('parent.child.details', $child->id) }}" class="btn btn-sm btn-info">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($children->count() == 0)
                                <tr>
                                    <td colspan="7" class="text-center">No children found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance History</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <tr>
                                    <td>2024-01-15</td>
                                    <td>John Doe Jr.</td>
                                    <td><span class="badge bg-success">Present</span></td>
                                    <td>8:00 AM</td>
                                    <td>3:00 PM</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>2024-01-14</td>
                                    <td>John Doe Jr.</td>
                                    <td><span class="badge bg-success">Present</span></td>
                                    <td>8:15 AM</td>
                                    <td>3:00 PM</td>
                                    <td>Late arrival</td>
                                </tr>
                                <tr>
                                    <td>2024-01-13</td>
                                    <td>John Doe Jr.</td>
                                    <td><span class="badge bg-warning">Late</span></td>
                                    <td>8:45 AM</td>
                                    <td>3:00 PM</td>
                                    <td>Late arrival</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('parent.attendance') }}" class="btn btn-primary">View Full Report</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades Modal -->
    <div class="modal fade" id="gradesModal" tabindex="-1" aria-labelledby="gradesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradesModalLabel">Academic Performance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Child</th>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Percentage</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe Jr.</td>
                                    <td>Mathematics</td>
                                    <td>A</td>
                                    <td>92%</td>
                                    <td>Excellent work!</td>
                                </tr>
                                <tr>
                                    <td>John Doe Jr.</td>
                                    <td>Science</td>
                                    <td>B+</td>
                                    <td>87%</td>
                                    <td>Good progress</td>
                                </tr>
                                <tr>
                                    <td>John Doe Jr.</td>
                                    <td>English</td>
                                    <td>A-</td>
                                    <td>89%</td>
                                    <td>Very good</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('parent.grades') }}" class="btn btn-primary">View Full Report</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Modal -->
    <div class="modal fade" id="messagesModal" tabindex="-1" aria-labelledby="messagesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="messagesModalLabel">Recent Messages</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sarah Teacher</td>
                                    <td>John's Progress</td>
                                    <td>John is doing very well in mathematics...</td>
                                    <td>Today</td>
                                    <td><span class="badge bg-warning">Unread</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="markAsRead(1)">Read</button>
                                        <button class="btn btn-sm btn-primary" onclick="showReplyModal(1, 'Sarah Teacher')">Reply</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mike Teacher</td>
                                    <td>Science Assignment</td>
                                    <td>Please check the new science assignment...</td>
                                    <td>Yesterday</td>
                                    <td><span class="badge bg-warning">Unread</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="markAsRead(2)">Read</button>
                                        <button class="btn btn-sm btn-primary" onclick="showReplyModal(2, 'Mike Teacher')">Reply</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('parent.chats') }}" class="btn btn-primary">View All Messages</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Message</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('parent.message.reply') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="message_id" id="replyMessageId">
                        <input type="hidden" name="teacher_id" id="replyTeacherId">
                        
                        <div class="mb-3">
                            <label for="replyTo" class="form-label">Reply to:</label>
                            <input type="text" class="form-control form-control-lg" id="replyTo" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reply_text" class="form-label">Your Reply:</label>
                            <textarea class="form-control" id="reply_text" name="reply_text" rows="6" required style="font-size: 16px; resize: vertical; min-height: 150px;" placeholder="Type your reply here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function markAsRead(messageId) {
            fetch(`/parent/message/read/${messageId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the badge to show as read
                    const row = event.target.closest('tr');
                    const badge = row.querySelector('.badge');
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Read';
                    
                    // Update button text
                    const button = event.target;
                    button.textContent = 'View';
                    button.disabled = true;
                    
                    // Update unread count in stats card
                    const unreadCount = document.querySelector('.stats-card .number');
                    if (unreadCount) {
                        const currentCount = parseInt(unreadCount.textContent);
                        if (currentCount > 0) {
                            unreadCount.textContent = currentCount - 1;
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking message as read');
            });
        }

        function showReplyModal(messageId, teacherName) {
            document.getElementById('replyMessageId').value = messageId;
            document.getElementById('replyTo').value = teacherName;
            document.getElementById('reply_text').value = '';
            
            const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
            replyModal.show();
        }
    </script>
    
    @include('layouts.partials.footer')
</div>
@endsection 