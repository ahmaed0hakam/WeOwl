@extends('layouts.app')

@section('title', 'Chat with Parents - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.teacher-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Chat with Parents</h2>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Parents List -->
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <h3>Available Parents</h3>
                    <div class="parent-list">
                        @foreach(\App\Models\ParentUser::with('students')->get() as $parent)
                        <div class="parent-item" onclick="selectParent({{ $parent->id }}, '{{ $parent->name }}')">
                            <div class="parent-avatar">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <div class="parent-info">
                                <h5>{{ $parent->name }}</h5>
                                <p class="text-muted">{{ $parent->students->count() }} children</p>
                                <span class="badge bg-success">Online</span>
                            </div>
                        </div>
                        @endforeach
                        @if(\App\Models\ParentUser::count() == 0)
                        <div class="text-center text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>No parents available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Chat Area -->
            <div class="col-md-8 mb-4">
                <div class="dashboard-card">
                    <div class="chat-header">
                        <h3 id="chatTitle">Select a parent to start chatting</h3>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div class="chat-messages" id="chatMessages">
                        <div class="text-center text-muted mt-5">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>Choose a parent from the list to start a conversation</p>
                        </div>
                    </div>
                    
                    <!-- Message Input -->
                    <div class="chat-input" id="chatInput" style="display: none;">
                        <form id="messageForm" action="{{ route('teacher.chat.send') }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" id="selectedParentId">
                            <div class="input-group">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control form-control-lg" name="subject" placeholder="Enter message subject..." required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" name="message" placeholder="Type your message here..." rows="6" required style="font-size: 16px; resize: vertical; min-height: 150px;"></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    
    <script>
        let selectedParentId = null;
        let selectedParentName = null;
        
        function selectParent(parentId, parentName) {
            selectedParentId = parentId;
            selectedParentName = parentName;
            
            // Update active state
            document.querySelectorAll('.parent-item').forEach(item => {
                item.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // Update chat title
            document.getElementById('chatTitle').textContent = `Chat with ${parentName}`;
            document.getElementById('selectedParentId').value = parentId;
            
            // Show chat input
            document.getElementById('chatInput').style.display = 'block';
            
            // Load chat messages from server
            loadChatMessages(parentId);
        }
        
        function loadChatMessages(parentId) {
            const chatMessages = document.getElementById('chatMessages');
            
            // Show loading
            chatMessages.innerHTML = `
                <div class="text-center text-muted mt-5">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Loading messages...</p>
                </div>
            `;
            
            // Fetch messages from server
            fetch(`/teacher/chat/messages/${parentId}`)
                .then(response => response.json())
                .then(messages => {
                    if (messages.length === 0) {
                        chatMessages.innerHTML = `
                            <div class="text-center text-muted mt-5">
                                <i class="fas fa-comments fa-3x mb-3"></i>
                                <p>No messages yet. Start the conversation!</p>
                            </div>
                        `;
                    } else {
                        displayMessages(messages);
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    chatMessages.innerHTML = `
                        <div class="text-center text-muted mt-5">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <p>Error loading messages. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        function displayMessages(messages) {
            const chatMessages = document.getElementById('chatMessages');
            const teacherId = {{ session('teacher_id') }};
            
            let messagesHtml = '';
            
            messages.forEach(message => {
                const isFromTeacher = message.recipient_type === 'parent' && 
                                    message.metadata && 
                                    JSON.parse(message.metadata).from_teacher == teacherId;
                
                const messageClass = isFromTeacher ? 'sent' : 'received';
                const messageTime = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                messagesHtml += `
                    <div class="message ${messageClass}">
                        <div class="message-content">
                            <div class="message-header">
                                <strong>${message.title}</strong>
                                <small class="message-time">${messageTime}</small>
                            </div>
                            <div class="message-body">
                                ${message.message}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            chatMessages.innerHTML = messagesHtml;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Handle form submission
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            if (!selectedParentId) {
                e.preventDefault();
                alert('Please select a parent first');
                return;
            }
            
            // Show sending indicator
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            // After form submission, reload messages
            setTimeout(() => {
                if (selectedParentId) {
                    loadChatMessages(selectedParentId);
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1000);
        });
        
        // Auto-refresh messages every 30 seconds
        setInterval(() => {
            if (selectedParentId) {
                loadChatMessages(selectedParentId);
            }
        }, 30000);
    </script>
    
    @include('layouts.partials.footer')
</div>
@endsection 