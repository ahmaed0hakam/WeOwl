<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="{{ route('parent.dashboard') }}" class="navbar-brand">
                <img src="{{ asset('images/WeOwl.png') }}" alt="WeOwl" width="50px" />
                WeOwl
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
                        <a href="{{ route('parent.attendance') }}" class="nav-link">Attendance</a>
                    </li>
                    <div style="height:20px; width:1px; background-color:white;"></div>
                    <li style="padding: 0 7px" class="nav-item">
                        <a href="{{ route('parent.chats') }}">
                            <i class="fas fa-comments" style="color:white"></i>
                        </a>
                    </li>
                    <div style="height:20px; width:1px; background-color:white;"></div>
                    <li class="nav-item">
                        <div class="" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown notification bell">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <span class="fas fa-bell" style="color:white"></span>
                                        @if(isset($notifications) && count($notifications) > 0)
                                            <span class="badge">{{ count($notifications) }}</span>
                                        @endif
                                    </a>
                                    <ul class="notification-list dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                        @if(!isset($notifications) || count($notifications) == 0)
                                            <li class="dropdown-item">There is no notification</li>
                                        @else
                                            @foreach($notifications->take(7) as $notification)
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       onclick="openModal('{{ $notification->id }}', '{{ $notification->title }}', '{{ $notification->content }}')">
                                                        {{ $notification->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <div style="height:20px; width:1px; background-color:white;"></div>
                    <li class="nav-item">
                        <div class="" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav" style="position: absolute !important;">
                                <li class="nav-item dropdown notification">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <span class="fas fa-user" style="color:white"></span>
                                    </a>
                                    <ul class="notification-list dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                        <li class="dropdown-item">
                                            <a href="{{ route('parent.profile') }}" class="nav-link">Profile</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{ route('parent.logout') }}" class="nav-link">Logout</a>
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

<script>
function openModal(id, title, content) {
    // Create modal for notification details
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'notificationModal';
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>${content}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
    
    modal.addEventListener('hidden.bs.modal', function () {
        document.body.removeChild(modal);
    });
}
</script> 