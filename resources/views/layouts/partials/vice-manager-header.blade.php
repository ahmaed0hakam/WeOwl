<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="{{ route('vice.dashboard') }}" class="navbar-brand">
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
                        <a href="{{ route('vice.classes') }}" class="nav-link">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vice.teachers') }}" class="nav-link">Teachers</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vice.add-user') }}" class="nav-link">Add User</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vice.attendance-reports') }}" class="nav-link">Attendance Reports</a>
                    </li>
                    <div style="height:20px; width:1px; background-color:white;"></div>
                    <li class="nav-item">
                        <div class="navbar-brand" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav" style="position: absolute !important;">
                                <li class="nav-item dropdown notification">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <span class="fas fa-user" style="color:white"></span>
                                    </a>
                                    <ul class="notification-list dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                        <li class="dropdown-item">
                                            <a href="{{ route('vice.profile') }}" class="nav-link">Profile</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{ route('vice.logout') }}" class="nav-link">Logout</a>
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