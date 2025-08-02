<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="{{ route('teacher.dashboard') }}" class="navbar-brand">
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
                        <a href="{{ route('teacher.classes') }}" class="nav-link">Classes</a>
                    </li>
                    <div style="height:20px; width:1px; background-color:white;"></div>
                    <li style="padding: 0 7px" class="nav-item">
                        <a href="{{ route('teacher.chats') }}">
                            <i class="fas fa-comments" style="color:white"></i>
                        </a>
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
                                            <a href="{{ route('teacher.profile') }}" class="nav-link">Profile</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{ route('teacher.logout') }}" class="nav-link">Logout</a>
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