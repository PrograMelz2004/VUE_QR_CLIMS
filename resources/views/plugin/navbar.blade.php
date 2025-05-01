<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #d35d00;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center">
            <img src="img/sc_logo.png" alt="EVSU-DC Logo" class="rounded-circle evsu-logo" width="40" height="40">
            <span class="ms-2" style="font-size: 1rem; color: white;">{{ config('app.system_long_name') }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mt-2">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('users.view') ? 'active' : '' }}" href="{{ route('users.view') }}">
                        <img src="img/users-alt.png" width="24" class="me-2"> Users
                    </a>
                </li>

                <li class="nav-item mt-2">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('items.view') ? 'active' : '' }}" href="{{ route('items.view') }}">
                        <img src="img/items.png" width="24" class="me-2"> Items
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('items.scan') ? 'active' : '' }}" href="{{ route('items.scan') }}">
                        <img src="img/qr-scan.png" width="24" class="me-2"> Transaction
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('items.reports') ? 'active' : '' }}" href="{{ route('items.reports') }}">
                        <img src="img/graph.png" width="24" class="me-2"> Reports
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="img/admin_logo.png" alt="Administrator" class="rounded-circle" width="40" style="box-shadow: 0 4px 8pxrgb(0, 0, 0);">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li class="text-center pt-3 border-bottom">
                            <img src="img/admin_logo.png" class="rounded-circle admin-logo" width="60">
                            <p class="text-white mt-2">{{ $user->first_name }} {{ $user->last_name }}</p>
                        </li>
                        <li class="mt-2">
                            <a class="dropdown-item text-white d-flex align-items-center {{ request()->routeIs('profile.view') ? 'active' : '' }}" href="{{ route('profile.view') }}">
                                <img src="img/slider.png" width="24" class="me-2"> User Profile
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item text-white d-flex align-items-center {{ request()->routeIs('system.edit') ? 'active' : '' }}" href="{{ route('system.edit') }}">
                                <img src="img/slider.png" width="24" class="me-2"> System Settings
                            </a>
                        </li>
                        <li class="d-flex justify-content-between p-1 border-top">
                            <a href="{{ route('system.view') }}" class="dropdown-item text-center text-white {{ request()->routeIs('system.view') ? 'active' : '' }}" style="flex: 1;">
                                <img src="img/question.png" alt="System" width="24" class="me-2"> About
                            </a>
                            <a href="{{ route('users.logout') }}" class="dropdown-item text-center text-white" style="flex: 1;">
                                <img src="img/sign-out-alt.png" alt="Logout" width="24" class="me-2"> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    @keyframes glow {
        from { box-shadow: 0 0 5px rgb(0, 0, 0); }
        to { box-shadow: 0 0 20px rgb(0, 0, 0); }
    }

    .admin-logo, .evsu-logo { animation: glow 1.5s infinite alternate; }

    .navbar-nav .nav-link, .navbar-toggler, .dropdown-item {
        transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
    }

    .navbar-nav .nav-link:hover, .navbar-toggler:hover, .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff !important;
        border-radius: 5px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .navbar-nav .nav-link.active, .dropdown-item.active {
        background-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .dropdown-menu { background: #D35D00; }
</style>
