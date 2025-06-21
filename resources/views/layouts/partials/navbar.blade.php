<nav class="navbar navbar-expand-lg" style="background-color: #FC5C14;">
    <div class="container">
        <a class="navbar-brand text-light" href="{{ url('/') }}">DMW CNC Solutions</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                {{-- @auth
                    @role('admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('roles.create') }}">Manage Roles</a></li>
                    @endrole

                    @role('manager')
                        <li class="nav-item"><a class="nav-link" href="{{ route('leaves.index') }}">Approve Leaves</a></li>
                    @endrole

                    @role('employee')
                        <li class="nav-item"><a class="nav-link" href="{{ route('leaves.create') }}">Apply Leave</a></li>
                    @endrole
                @endauth --}}
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
