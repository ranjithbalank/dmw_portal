<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Meta and Title --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'My DMW PORTAL' }}</title>

    {{-- Fonts and CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+AU+QLD:wght@100..400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- Custom Styles --}}
    <style>
        @auth .sidebar {
                width: 250px;
                min-height: 100vh;
                background: #343a40;
                color: #fff;
            }

            .sidebar a {
                color: #fff;
                text-decoration: none;
            }

            .sidebar a:hover {
                background-color: rgba(255, 255, 255, 0.623);
                padding-left: 10px;
                transition: 0.3s;
                border-radius: 10px;
            }

            @endauth
            .main-content {
                flex-grow: 1;
                padding: 2rem;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.35);
                border-radius: 1rem;
                text-align: center;
                padding: 1rem;
                text-decoration: none;
                display: block;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                transition: all 0.3s;
            }

            .glass-card:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }
        </style>

        @stack('styles')

        {{-- PWA --}}
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#ffffff">
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/serviceworker.js')
                    .then(registration => console.log('ServiceWorker registered:', registration))
                    .catch(error => console.error('ServiceWorker registration failed:', error));
            }
        </script>
    </head>

    <body>
        <div id="app">
            {{-- 🔶 Navbar --}}
            @include('layouts.partials.navbar')

            {{-- 🔶 Offcanvas Toggle Button (Mobile Only) --}}
            <div class="d-md-none p-2 bg-dark text-white">
                <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar"
                    aria-controls="offcanvasSidebar">
                    <i class="bi bi-list"></i> Menu
                </button>
            </div>

            {{-- 🔶 Offcanvas Sidebar --}}
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar"
                aria-labelledby="offcanvasSidebarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @auth
                        <div class="text-center mb-4">
                            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                            <h6 class="mt-2">{{ Auth::user()->name }}</h6>
                            <small class="text-muted d-block">{{ Auth::user()->email }}</small>
                            <hr class="bg-light">
                        </div>
                        <ul class="nav flex-column">

                            <li class="nav-item mb-2">
                                <a href="{{ route('users.index') }}" class="nav-link text-white">
                                    <i class="bi bi-people-fill me-2"></i> Users
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('home') }}"
                                    class="nav-link {{ request()->is('dashboard') ? 'text-warning fw-bold' : 'text-white' }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('roles.index') }}" class="nav-link text-white">
                                    <i class="bi bi-people-fill me-2"></i> Roles
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('users.index') }}" class="nav-link text-white">
                                    <i class="bi bi-people-fill me-2"></i> Users
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('leaves.index') }}" class="nav-link text-white">
                                    <i class="bi bi-calendar-check-fill me-2"></i> Leaves
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('internal-jobs.index') }}" class="nav-link text-white">
                                    <i class="bi bi-briefcase me-2"></i> Jobs
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('circulars.index') }}" class="nav-link text-white">
                                    <i class="bi bi-file-earmark-text me-2"></i> Circulars
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('events.index') }}" class="nav-link text-white">
                                    <i class="bi bi-calendar-event me-2"></i> Events
                                </a>
                            </li>
                        </ul>
                    @endauth
                </div>
            </div>

            {{-- 🔶 Layout for Desktop --}}
            <div class="d-none d-md-flex">
                {{-- Sidebar for Desktop --}}
                <aside class="sidebar d-flex flex-column p-3">
                    @auth

                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <a href="{{ route('home') }}"
                                    class="nav-link {{ request()->is('dashboard') ? 'text-warning fw-bold' : 'text-white' }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('users.edit', auth()->user()->id) }}"
                                    class="nav-link {{ request()->is('dashboard') ? 'text-warning fw-bold' : 'text-white' }}">
                                    <i class="bi bi-person-circle me-2"></i> Profile
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('leaves.index') }}" class="nav-link text-white">
                                    <i class="bi bi-calendar-check-fill me-2"></i> Leaves
                                </a>
                            </li>
                            @hasrole('Admin')
                                <li class="nav-item mb-2">
                                    <a href="{{ route('users.index') }}" class="nav-link text-white">
                                        <i class="bi bi-people-fill me-2"></i> Users
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a href="{{ route('roles.index') }}" class="nav-link text-white">
                                        <i class="bi bi-people-fill me-2"></i> Roles
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a href="{{ route('permissions.index') }}" class="nav-link text-white">
                                        <i class="bi bi-people-fill me-2"></i> Permissions
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a href="{{ route('users.import_form') }}" class="nav-link text-white">
                                        <i class="bi bi-people-fill me-2"></i> Bulk Import Users
                                    </a>
                                </li>
                            @endhasrole
                            <li class="nav-item mb-2">
                                <a href="{{ route('internal-jobs.index') }}" class="nav-link text-white">
                                    <i class="bi bi-briefcase me-2"></i> Jobs
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('circulars.index') }}" class="nav-link text-white">
                                    <i class="bi bi-file-earmark-text me-2"></i> Circulars
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('events.index') }}" class="nav-link text-white">
                                    <i class="bi bi-calendar-event me-2"></i> Events
                                </a>
                            </li>


                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                                @csrf
                                <button type="submit" class="btn btn-outline-light w-100 rounded-pill mt-4">
                                    <i class="bi bi-box-arrow-right me-0"></i> Logout
                                </button>
                            </form>
                        </ul>
                    @endauth
                </aside>


                {{-- Main Content --}}
                <main class="main-content">
                    <div class="container position-relative">
                        {{-- Toast Messages --}}
                        @if (session('success'))
                            <div class="toast text-bg-success border-0 show mb-2" role="alert">
                                <div class="d-flex">
                                    <div class="toast-body">{{ session('success') }}</div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                        data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="toast text-bg-danger border-0 show" role="alert">
                                <div class="d-flex">
                                    <div class="toast-body">{{ session('error') }}</div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                        data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        {{-- Dynamic Content --}}
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        {{-- Scripts --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    width: 'style'
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                let toastEl = document.querySelector('.toast');
                if (toastEl) {
                    let toast = new bootstrap.Toast(toastEl);
                    toast.show();
                }
            });
        </script>

        @yield('scripts')
        @stack('scripts')
    </body>

    </html>
