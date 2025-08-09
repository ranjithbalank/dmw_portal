@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        <span>{{ __('Assigned Unit Permissions') }}</span>
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="d-flex justify-content-end mb-3">
                            @hasanyrole(['HR', 'Admin'])
                                <a href="{{ route('assign-unit-permissions.create') }}" class="btn btn-success shadow-sm">
                                    <i class="bi bi-person-plus"></i> Create Circular
                                </a>
                            @endhasanyrole
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="assignTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                        <th>Unit</th>
                                        <th>Module</th>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedAssignments as $key => $assignmentGroup)
                                        @php
                                            $firstItem = $assignmentGroup->first();
                                            $assignmentId = $firstItem->id;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ strtoupper($firstItem->role_name) }}</td>
                                            <td>{{ strtoupper($firstItem->unit_name) }} ({{ $firstItem->unit_code }})</td>
                                            <td>{{ strtoupper($firstItem->module_name) }}</td>
                                            <td>
                                                @foreach ($assignmentGroup as $assignment)
                                                    <span
                                                        class="badge bg-primary mb-1">{{ ucfirst($assignment->permission_name) }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('assign-unit-permissions.edit', $assignmentId) }}"
                                                        class="btn btn-sm btn-warning me-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('assign-unit-permissions.destroy', $assignmentId) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@section('scripts')
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery + DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        /* Add spacing under the search bar */
        div.dataTables_filter {
            margin-bottom: 1rem;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#assignTable').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: "Search departments...",
                    search: "",
                }
            });
        });

        // Modal logic
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-role-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');

                    document.getElementById('roleModalLabel').textContent = 'Loading...';
                    document.getElementById('roleModalBody').innerHTML = `
                    <div class="text-center p-3">
                        <span class="spinner-border text-warning"></span> Fetching data...
                    </div>`;

                    fetch(`/roles/${roleId}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('roleModalLabel').textContent =
                                'Role Info - ' + data.name;
                            document.getElementById('roleModalBody').innerHTML = `
                            <table class="table table-bordered table-striped text-start">
                                <tr><th>Name</th><td>${data.name}</td></tr>
                                <tr><th>Guard</th><td>${data.guard_name}</td></tr>
                                <tr><th>Status</th><td>${data.status ?? 'Active'}</td></tr>
                            </table>`;

                            const modal = new bootstrap.Modal(document.getElementById(
                                'roleModal'));
                            modal.show();
                        })
                        .catch(err => {
                            document.getElementById('roleModalBody').innerHTML = `
                            <div class="alert alert-danger">Error loading data.</div>`;

                            const modal = new bootstrap.Modal(document.getElementById(
                                'roleModal'));
                            modal.show();
                        });
                });
            });
        });
    </script>
@endsection
@endsection
