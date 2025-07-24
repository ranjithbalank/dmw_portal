@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-4">

        {{-- 🔹 Dashboard Main Row Container --}}
        <div class="row g-4">
            {{-- 🔸 Admin Panel (Visible only to Admins) --}}
            @hasrole('Admin')
                <div class="col-12">
                    <div class="rounded-4 overflow-hidden shadow border border-1 border-dark">
                        {{-- Header --}}
                        <div class="px-4 py-2 text-white fw-bold fs-6"
                            style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                            <i class="bi bi-person-gear me-2"></i> Admin Panel
                        </div>
                        {{-- Body --}}
                        <div class="bg-glass p-3 rounded-bottom-4">
                            <div class="row g-3">
                                {{-- Roles Management --}}
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('roles.index') }}"
                                        class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                        <i class="bi bi-person-lock fs-2 mb-1 text-primary"></i>
                                        <span class="fw-semibold small">Roles</span>
                                    </a>
                                </div>

                                {{-- Permissions Management --}}
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('permissions.index') }}"
                                        class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                        <i class="bi bi-shield-lock-fill fs-2 mb-1 text-primary"></i>
                                        <span class="fw-semibold small">Role-Permissions</span>
                                    </a>
                                </div>

                                {{-- bulk data upload --}}
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('users.import_form') }}"
                                        class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                        <i class="bi bi-cloud-upload-fill fs-2 mb-1 text-primary"></i>
                                        <span class="fw-semibold small">Bulk Upload</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endhasrole

            {{-- 🔸 HR Section (Visible to Admin and HR) --}}
            {{-- @hasrole(['Admin', 'HR']) --}}
                <div class="col-12">
                    <div class="rounded-4 overflow-hidden shadow border border-1 border-dark">
                        {{-- Header --}}
                        <div class="px-4 py-2 text-white fw-bold fs-6"
                            style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                            <i class="bi bi-people-fill me-2"></i> Human Resource Management
                        </div>
                        {{-- Body --}}
                        <div class="bg-glass p-3 rounded-bottom-4">
                            <div class="row g-3">
                                {{-- Users --}}
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('users.index') }}"
                                        class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                        <i class="bi bi-people-fill fs-2 mb-1 text-info"></i>
                                        <span class="fw-semibold small">Users</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- @endhasrole --}}

            {{-- 🔸 Leave Management Section --}}
            <div class="col-12">
                <div class="rounded-4 overflow-hidden shadow border border-1 border-dark">
                    {{-- Header --}}
                    <div class="px-4 py-2 text-white fw-bold fs-6"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        <i class="bi bi-calendar-week me-2"></i> Leave Management
                    </div>
                    {{-- Body --}}
                    <div class="bg-glass p-3 rounded-bottom-4">
                        <div class="row g-3">
                            {{-- Leaves --}}
                            <div class="col-md-3 col-6">
                                <a href="{{ route('leaves.index') }}"
                                    class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                    <i class="bi bi-calendar-check-fill fs-2 mb-1 text-warning"></i>
                                    <span class="fw-semibold small">Leaves</span>
                                </a>
                            </div>
                            {{-- Holiday List --}}
                            <div class="col-md-3 col-6">
                                <a href="{{ route('holidays.index') }}"
                                    class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                    <i class="bi bi-calendar3 fs-2 mb-1 text-warning"></i>
                                    <span class="fw-semibold small">Holiday List</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 🔸 Asset & Maintenance Management --}}
            {{-- <div class="col-12">
                <div class="rounded-4 overflow-hidden shadow border border-1 border-dark"> --}}
                    {{-- Header --}}
                    {{-- <div class="px-4 py-2 text-white fw-bold fs-6"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        <i class="bi bi-tools me-2"></i>Maintenance Management
                    </div> --}}
                    {{-- Body --}}
                    {{-- <div class="bg-glass p-3 rounded-bottom-4">
                        <div class="row g-3"> --}}
                            {{-- Tickets --}}
                            {{-- <div class="col-md-3 col-6">
                                <a href="{{ route('asset-tickets.index') }}"
                                    class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                    <i class="bi bi-clock-history fs-2 mb-1 text-success"></i>
                                    <span class="fw-semibold small">Tickets</span>
                                </a>
                            </div> --}}

                            {{-- Maintenance Checklist (placeholder link) --}}
                            {{-- <div class="col-md-3 col-6">
                                <a href="#"
                                    class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                    <i class="bi bi-card-checklist fs-2 mb-1"></i>
                                    <span class="fw-semibold small">Maintenance Checklist</span>
                                </a>
                            </div> --}}
                        {{-- </div>
                    </div>
                </div>
            </div> --}}
        {{-- </div> --}}

        {{-- 🔸 Job Posting and Circulars --}}
        <div class="col-12">
            <div class="rounded-4 overflow-hidden shadow border border-1 border-dark">
                {{-- Header --}}
                <div class="px-4 py-2 text-white fw-bold fs-6"
                    style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                    <i class="bi bi-megaphone-fill me-2"></i> Circulars & Job Postings
                </div>
                {{-- Body --}}
                <div class="bg-glass p-3 rounded-bottom-4">
                    <div class="row g-3">
                        {{-- Internal Job Posting --}}
                        <div class="col-md-3 col-6">
                            <a href="{{ route('internal-jobs.index') }}"
                                class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                <i class="bi bi-briefcase fs-2 mb-1 text-danger"></i>
                                <span class="fw-semibold small">Job Posting</span>
                            </a>
                        </div>

                        {{-- Circulars --}}
                        <div class="col-md-3 col-6">
                            <a href={{ route('circulars.index') }}
                                class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                <i class="bi bi-file-earmark-text fs-2 mb-1 text-primary"></i>
                                <span class="fw-semibold small">Circulars</span>
                            </a>
                        </div>

                        {{-- Events --}}
                        <div class="col-md-3 col-6">
                            <a href={{ route('events.index') }}
                                class="glass-card border border-1 border-dark text-decoration-none d-flex flex-column align-items-center p-2">
                                <i class="bi bi-calendar-event fs-2 mb-1 text-success"></i>
                                <span class="fw-semibold small">Events</span>
                            </a>
                        </div>
                        {{-- Add more cards below if needed --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
