@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header text-start fw-bold fs-5" style="background: #FC5C14; color: white;">
                    Dashboard
                </div>

                <div class="card-body">
                    {{-- Flash Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show fw-semibold" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Admin Panel --}}
                    @hasrole('Admin')
                        <div class="container py-2">
                            <h6 class="text-muted fw-bold fst-italic mb-2">Admin Panel</h6>
                            <hr class="mt-0 mb-2">
                            <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <a href="{{ route('roles.index') }}"
                                        class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm fw-semibold">
                                        <i class="bi bi-person-lock"></i> <span>Roles</span>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('permissions.index') }}"
                                        class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm fw-semibold">
                                        <i class="bi bi-shield-lock-fill"></i> <span>Role-Permissions</span>
                                    </a>
                                </div>
                            </div>
                        @endrole

                        {{-- General Section --}}
                        @hasrole(['Manager', 'Admin', 'Employee'])
                            <h6 class="text-muted fw-bold fst-italic mb-2">Human Resource Management</h6>
                            <hr class="mt-0 mb-2">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <a href="{{ route('users.index') }}"
                                        class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm fw-semibold">
                                        <i class="bi bi-people-fill"></i> <span>Users</span>
                                    </a>
                                </div>
                            @endrole

                            <h6 class="text-muted fw-bold fst-italic mb-2">Leave Management</h6>
                            <hr class="mt-0 mb-2">
                            <div class="row"> {{-- Added missing .row --}}
                                <div class="col-md-3">
                                    <a href="{{ route('leaves.index') }}"
                                        class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm fw-semibold">
                                        <i class="bi bi-calendar-check-fill"></i> <span>Leaves</span>
                                    </a>
                                </div>
                                {{-- check the redirection link  --}}
                                <div class="col-md-3">
                                    <a href="{{ route('holidays.index') }}"
                                        class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 small shadow-sm fw-semibold">
                                        <i class="bi bi-calendar-check-fill"></i> <span>Holiday List</span>
                                    </a>
                                </div>
                            </div> {{-- Closed .row --}}
                        </div> {{-- Closed .container --}}

                        <div class="container py-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
