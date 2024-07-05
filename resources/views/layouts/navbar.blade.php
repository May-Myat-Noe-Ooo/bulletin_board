<nav class="navbar navbar-light navbar-expand-lg py-0">
    <div class="container-fluid">
        
        <ul class="navbar-nav me-auto flex-row mb-2 mb-lg-0">
            <li class="nav-item d-flex align-items-center {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
            </li>
            @auth
            @if(auth()->user()->type == 0)
                    <li class="nav-item d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                @endif
            <li class="nav-item d-flex align-items-center {{ request()->routeIs('displayuser') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('displayuser') }}">Users</a>
            </li>
            <li class="nav-item d-flex align-items-center {{ request()->routeIs('postlist.index') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('postlist.index') }}">Posts</a>
            </li>
            @endauth
        </ul>
        @auth
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item d-flex align-items-center {{ request()->routeIs('registeruser') ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('registeruser') }}">Create User</a>
                </li>
                <li class="nav-item dropdown d-flex align-items-center">
                    <a class="nav-link text-white d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                        <img src="{{ asset(auth()->user()->profile) }}" alt="error" class="rounded-circle ms-2" width="40" height="40">
                        
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-success" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('showprofile', auth()->user()->id) }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
                
            </ul>
        </div>
        @endauth
    </div>
</nav>
