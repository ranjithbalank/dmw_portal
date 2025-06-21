@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="text-center card-header" style="background: #FC5C14; color: white;"><b>Dashboard</b></div>

                <div class="card-body">
                    {{-- Flash Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="container py-3">

                        {{-- General Section --}}
                        <h6 class="text-muted mb-3">General</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <a href="{{ route('users.index') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm">
                                    <i class="bi bi-people-fill"></i> Users
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('leaves.index') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm">
                                    <i class="bi bi-calendar-check-fill"></i> Leaves
                                </a>
                            </div>
                        </div>

                        {{-- Admin Panel Section --}}
                        <h6 class="text-muted mb-3">Admin Panel</h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('roles.index') }}" class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm">
                                    <i class="bi bi-person-lock"></i> Roles
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('permissions.index') }}" class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm">
                                    <i class="bi bi-shield-lock-fill"></i> Role-Permissions
                                </a>
                            </div>
                            {{-- Optional Dropdown --}}
                            {{-- <div class="col-md-3 dropdown">
                                <button class="btn btn-dark w-100 dropdown-toggle d-flex align-items-center justify-content-center gap-2 small shadow-sm"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill"></i> Settings
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li><a class="dropdown-item" href="#">System Logs</a></li>
                                    <li><a class="dropdown-item" href="#">Backup</a></li>
                                    <li><a class="dropdown-item" href="#">Audit Trail</a></li>
                                </ul>
                            </div> --}}
                        </div>

                    </div> {{-- end container --}}
                </div>
            </div>
        </div>
    </div>
@endsection
