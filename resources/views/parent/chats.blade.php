@extends('layouts.app')

@section('title', 'Chat with Teachers - WeOwl')

@section('content')
<div class="dashboard-container">
    @include('layouts.partials.parent-header')
    
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="welcome">Chat with Teachers</h2>
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Teachers List -->
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <h3>Available Teachers</h3>
                    <div class="teacher-list">
                        @foreach($teachers as $teacher)
                        <div class="teacher-item" onclick="selectTeacher({{ $teacher->id }}, '{{ $teacher->name }}', '{{ $teacher->subject }}')">
                            <div class="teacher-avatar">
                                <i class="fas fa-user-tie fa-2x"></i>
                            </div>
                            <div class="teacher-info">
                                <h5>{{ $teacher->name }}</h5>
                                <p class="text-muted">{{ $teacher->subject }}</p>
                                <span class="badge bg-success">Online</span>
                            </div>
                        </div>
                        @endforeach
                        @if($teachers->count() == 0)
                        <div class="text-center text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>No teachers available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Chat Area -->
            <div class="col-md-8 mb-4">
                <div class="dashboard-card">
                    <div class="chat-header">
                        <h3 id="chatTitle">Select a teacher to start chatting</h3>
                        <a href="{{ route('parent.test-messages') }}" class="btn btn-sm btn-warning">Create Test Message</a>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div class="chat-messages" id="chatMessages">
                        <div class="text-center text-muted mt-5">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>Choose a teacher from the list to start a conversation</p>
                        </div>
                    </div>
                    
                    <!-- Message Input -->
                    <div class="chat-input" id="chatInput" style="display: none;">
                        <form id="messageForm" action="{{ route('parent.chat.send') }}" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" id="selectedTeacherId">
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
    
    <style>
        .teacher-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .teacher-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid rgba(245, 177, 112, 0.2);
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .teacher-item:hover {
            background: rgba(245, 177, 112, 0.1);
            border-color: #f5b170;
        }
        
        .teacher-item.active {
            background: rgba(245, 177, 112, 0.2);
            border-color: #f5b170;
        }
        
        .teacher-avatar {
            margin-right: 15px;
            color: #f5b170;
        }
        
        .teacher-info h5 {
            margin: 0;
            color: #ffffff;
        }
        
        .teacher-info p {
            margin: 5px 0;
            font-size: 0.9rem;
        }
        
        .chat-header {
            border-bottom: 1px solid rgba(245, 177, 112, 0.2);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 15px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }
        
        .message.sent {
            justify-content: flex-end;
        }
        
        .message.received {
            justify-content: flex-start;
        }
        
        .message-content {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            word-wrap: break-word;
        }
        
        .message.sent .message-content {
            background: #f5b170;
            color: #0d121b;
        }
        
        .message.received .message-content {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        
        .message-time {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-top: 5px;
        }
        
        .chat-input {
            border-top: 1px solid rgba(245, 177, 112, 0.2);
            padding-top: 20px;
        }
        
        .chat-input .input-group {
            flex-direction: column;
        }
        
        .chat-input .form-control {
            margin-bottom: 10px;
        }
        
        .chat-input textarea {
            resize: none;
        }
        
        /* Enhanced form styling for chat */
        .chat-input .form-control {
            border-radius: 10px;
            border: 2px solid rgba(245, 177, 112, 0.3);
            transition: all 0.3s ease;
        }
        
        .chat-input .form-control:focus {
            border-color: #f5b170;
            box-shadow: 0 0 0 0.2rem rgba(245, 177, 112, 0.25);
        }
        
        .chat-input .form-control-lg {
            font-size: 18px;
            padding: 15px 20px;
        }
        
        .chat-input textarea {
            font-size: 16px;
            line-height: 1.6;
            padding: 15px 20px;
        }
        
        .chat-input .btn-lg {
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 10px;
        }
        
        .chat-input .form-label {
            font-weight: 600;
            color: #f5b170;
            margin-bottom: 10px;
        }
        
        /* Message header styling */
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .message-header strong {
            font-size: 14px;
            font-weight: 600;
        }
        
        .message-time {
            font-size: 12px;
            opacity: 0.7;
        }
        
        .message-body {
            line-height: 1.5;
            word-wrap: break-word;
        }
        
        /* Loading animation */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    <script>
        let selectedTeacherId = null;
        let selectedTeacherName = null;
        
        function selectTeacher(teacherId, teacherName, subject) {
            selectedTeacherId = teacherId;
            selectedTeacherName = teacherName;
            
            // Update active state
            document.querySelectorAll('.teacher-item').forEach(item => {
                item.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // Update chat title
            document.getElementById('chatTitle').textContent = `Chat with ${teacherName} (${subject})`;
            document.getElementById('selectedTeacherId').value = teacherId;
            
            // Show chat input
            document.getElementById('chatInput').style.display = 'block';
            
            // Load chat messages from server
            loadChatMessages(teacherId);
        }
        
        function loadChatMessages(teacherId) {
            const chatMessages = document.getElementById('chatMessages');
            
            // Show loading
            chatMessages.innerHTML = `
                <div class="text-center text-muted mt-5">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Loading messages...</p>
                </div>
            `;
            
            // Fetch messages from server
            fetch(`/parent/chat/messages/${teacherId}`)
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
            const parentId = {{ session('parent_id') }};
            
            console.log('Messages received:', messages); // Debug log
            
            let messagesHtml = '';
            
            messages.forEach(message => {
                console.log('Processing message:', message); // Debug log
                
                // Check if message is from parent
                const isFromParent = message.recipient_type === 'teacher' && 
                                   message.metadata && 
                                   JSON.parse(message.metadata).from_parent == parentId;
                
                console.log('Is from parent:', isFromParent); // Debug log
                
                const messageClass = isFromParent ? 'sent' : 'received';
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
            if (!selectedTeacherId) {
                e.preventDefault();
                alert('Please select a teacher first');
                return;
            }
            
            // Show sending indicator
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            // After form submission, reload messages
            setTimeout(() => {
                if (selectedTeacherId) {
                    loadChatMessages(selectedTeacherId);
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1000);
        });
        
        // Auto-refresh messages every 30 seconds
        setInterval(() => {
            if (selectedTeacherId) {
                loadChatMessages(selectedTeacherId);
            }
        }, 30000);
    </script>
    
    @include('layouts.partials.footer')
</div>
@endsection 