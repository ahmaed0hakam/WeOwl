@extends('layouts.app')

@section('title', 'Messages - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Messages</h2>
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Messages List -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>All Messages</h3>
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
                                @foreach($messages as $message)
                                <tr class="message-row" data-message-id="{{ $message->id }}">
                                    <td>
                                        <strong>{{ $message->title }}</strong>
                                        <br><small class="text-muted">Teacher</small>
                                    </td>
                                    <td>{{ $message->title }}</td>
                                    <td>
                                        <div class="message-preview">
                                            {{ Str::limit($message->message, 100) }}
                                        </div>
                                    </td>
                                    <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $message->is_read ? 'bg-success' : 'bg-warning' }}">
                                            {{ $message->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="readMessage({{ $message->id }})">
                                            {{ $message->is_read ? 'View' : 'Read' }}
                                        </button>
                                        <button class="btn btn-sm btn-primary" onclick="showReplyModal({{ $message->id }}, 'Teacher')">
                                            Reply
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @if($messages->count() == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No messages available</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Message Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3>Message Statistics</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ $messages->count() }}</div>
                                <div class="label">Total Messages</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ $messages->where('is_read', false)->count() }}</div>
                                <div class="label">Unread Messages</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ $messages->where('is_read', true)->count() }}</div>
                                <div class="label">Read Messages</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card text-center">
                                <div class="number">{{ $messages->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                                <div class="label">This Week</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Detail Modal -->
    <div class="modal fade" id="messageDetailModal" tabindex="-1" aria-labelledby="messageDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageDetailModalLabel">Message Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="messageDetailContent">
                        <!-- Message content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="showReplyModalFromDetail()">Reply</button>
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
        let currentMessageId = null;
        
        function readMessage(messageId) {
            currentMessageId = messageId;
            
            // Mark as read via AJAX
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
                    const row = document.querySelector(`[data-message-id="${messageId}"]`);
                    const badge = row.querySelector('.badge');
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Read';
                    
                    // Update button text
                    const button = row.querySelector('.btn-info');
                    button.textContent = 'View';
                    
                    // Update message statistics
                    updateMessageStats();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
            
            // Show message detail modal
            showMessageDetail(messageId);
        }
        
        function updateMessageStats() {
            // Update total messages count
            const totalMessages = document.querySelectorAll('.message-row').length;
            document.querySelector('.stats-card:nth-child(1) .number').textContent = totalMessages;
            
            // Update unread messages count
            const unreadMessages = document.querySelectorAll('.badge.bg-warning').length;
            document.querySelector('.stats-card:nth-child(2) .number').textContent = unreadMessages;
            
            // Update read messages count
            const readMessages = document.querySelectorAll('.badge.bg-success').length;
            document.querySelector('.stats-card:nth-child(3) .number').textContent = readMessages;
        }
        
        function showMessageDetail(messageId) {
            // In a real app, you would fetch the message details from the server
            // For now, we'll show sample content
            const content = `
                <div class="message-detail">
                    <h6>Subject: Sample Message Subject</h6>
                    <p class="text-muted">From: Teacher • Date: ${new Date().toLocaleDateString()}</p>
                    <hr>
                    <p>This is a sample message content. In a real application, this would be the actual message content loaded from the database.</p>
                    <p>The message would contain important information about your child's progress, upcoming events, or any other school-related communication.</p>
                </div>
            `;
            
            document.getElementById('messageDetailContent').innerHTML = content;
            
            const modal = new bootstrap.Modal(document.getElementById('messageDetailModal'));
            modal.show();
        }
        
        function showReplyModal(messageId, teacherName) {
            currentMessageId = messageId;
            document.getElementById('replyMessageId').value = messageId;
            document.getElementById('replyTo').value = teacherName;
            document.getElementById('reply_text').value = '';
            
            const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
            replyModal.show();
        }
        
        function showReplyModalFromDetail() {
            // Close the detail modal first
            const detailModal = bootstrap.Modal.getInstance(document.getElementById('messageDetailModal'));
            detailModal.hide();
            
            // Show reply modal
            showReplyModal(currentMessageId, 'Teacher');
        }
    </script>
    
    @include('layouts.partials.footer')
</div>

<style>
    .message-preview {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Enhanced form styling for messages */
    .modal .form-control {
        border-radius: 10px;
        border: 2px solid rgba(245, 177, 112, 0.3);
        transition: all 0.3s ease;
    }
    
    .modal .form-control:focus {
        border-color: #f5b170;
        box-shadow: 0 0 0 0.2rem rgba(245, 177, 112, 0.25);
    }
    
    .modal .form-control-lg {
        font-size: 18px;
        padding: 15px 20px;
    }
    
    .modal textarea {
        font-size: 16px;
        line-height: 1.6;
        padding: 15px 20px;
    }
    
    .modal .form-label {
        font-weight: 600;
        color: #f5b170;
        margin-bottom: 10px;
    }
    
    .message-detail {
        padding: 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .message-detail h6 {
        color: #f5b170;
        margin-bottom: 10px;
    }
    
    .message-detail p {
        line-height: 1.6;
        margin-bottom: 15px;
    }
</style>

@endsection 