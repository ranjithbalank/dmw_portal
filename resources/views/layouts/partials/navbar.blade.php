<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
    <div class="container">
        <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
            <span class="navbar-brand text-light ms-2 fw-bold">DMW CNC Solutions</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto"></ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    {{-- Add login/register if needed --}}
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#profileModal">
                                    <i class="bi bi-person-circle"></i> Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right text-danger"> Logout</i>
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- Profile Modal -->

@auth
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Large modal for spacing -->
            <div class="modal-content shadow-sm rounded-4">
                <!-- Modal Header -->
                <div class="modal-header text-white rounded-top-4"
                    style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                    <h5 class="modal-title" id="profileModalLabel"><i class="bi bi-person-circle me-2"></i>User Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body px-4 py-3">
                    <!-- Top Avatar & Basic Info -->
                    <div class="text-center mb-4">
                        <div class="d-inline-block position-relative">
                            <i class="bi bi-person-circle" style="font-size: 5rem; color: #f7b733;"></i>
                        </div>
                        <h4 class="mt-3 mb-1">{{ Auth::user()->name }}</h4>
                        <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                            <strong>Employee ID:</strong> {{ Auth::user()->employee_id ?? 'N/A' }}
                        </p>
                        <p class="text-muted" style="font-size: 0.95rem;">{{ Auth::user()->email }}</p>
                        <hr>
                    </div>

                    <!-- Info Grid -->
                    <div class="row g-3">
                        <div class="col-md-4">

                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Designation</p>
                                <h6 class="mb-0  text-primary text-break text-wrap"
                                    style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                                    <B>{{ Auth::user()->designation ?? 'N/A' }}</b>
                                </h6>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Unit</p>
                                <h6 class="mb-0">{{ Auth::user()->unit ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Department</p>
                                <h6 class="mb-0">{{ Auth::user()->department ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Date of Joining</p>
                                <b>{{ Auth::user()->doj ? \Carbon\Carbon::parse(Auth::user()->doj)->format('d M Y') : 'N/A' }}</b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Shift</p>
                                <b>{{ Auth::user()->type_emp ?? 'N/A' }}</b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Manager</p>
                                <b>{{ Auth::user()->manager?->name ?? 'N/A' }}</b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Last Login</p>
                                <b>
                                    {{ Auth::user()->last_login_at
                                        ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y, h:i A')
                                        : 'N/A' }}
                                </b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Last Logout</p>
                                <b>
                                    {{ Auth::user()->last_logout_at
                                        ? \Carbon\Carbon::parse(Auth::user()->last_logout_at)->format('d M Y, h:i A')
                                        : 'N/A' }}
                                </b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100">
                                <p class="text-muted mb-1">Status</p>
                                <b>
                                    @if (Auth::user()->status == 'active')
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Inactive</span>
                                    @endif
                                </b>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endauth
