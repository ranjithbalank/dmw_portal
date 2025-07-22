<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'My DMW PORTAL' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
            padding: 6px 12px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            font-size: 1rem;
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #212529;
            line-height: 24px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            right: 10px;
        }

        .select2-container {
            width: 100% !important;
        }

        .bg-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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

        /* ✅ Hide scrollbar but allow scroll */
        body {
            overflow-y: scroll;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        body::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }
    </style>

    @stack('styles')
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ffffff">
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js')
                .then(function(registration) {
                    console.log('ServiceWorker registered:', registration);
                })
                .catch(function(error) {
                    console.error('ServiceWorker registration failed:', error);
                });
        }
    </script>
</head>

<body>
    <div id="app">
        @include('layouts.partials.navbar')

        <main class="py-4">
            <div class="container position-relative">

                {{-- Flash Success Message --}}
                @if (session('success'))
                    <div class="toast align-items-end text-bg-success border-0 show mb-2" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                {{-- Error Toast --}}
                @if (session('error'))
                    <div class="toast align-items-end text-bg-danger border-0 show" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                {{-- Main Content --}}
                @yield('content')

            </div>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 Init -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: 'style'
            });
        });
    </script>

    <!-- Toast Auto Show -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let toastEl = document.querySelector('.toast');
            if (toastEl) {
                let toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>

    <!-- Page Specific Scripts -->
    @yield('scripts')
    @stack('scripts')
</body>

</html>
