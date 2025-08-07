@extends('layouts.app')

@section('title', 'Department List')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        Departments
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('departments.create') }}" class="btn btn-success shadow-sm">
                                <i class="bi bi-plus-circle"></i> Create Department
                            </a>
                        </div>

                        {{-- @if ($roles->isEmpty()) --}}
                            {{-- <div class="alert alert-warning text-center">No Roles records found.</div> --}}
                        {{-- @else --}}
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-start">{{ ucfirst($role->name) }}</td>
                                                <td class="text-center">
                                                    @if ($role->status == 'inactive')
                                                        <span
                                                            class="btn btn-sm btn-danger fw-bold">{{ ucfirst($role->status) }}</span>
                                                    @else
                                                        <span
                                                            class="btn btn-sm btn-success fw-bold">{{ ucfirst($role->status) }}</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <!-- Eye Button to Trigger Dynamic Modal -->
                                                    <button type="button" class="btn btn-info btn-sm view-role-btn"
                                                        data-role-id="{{ $role->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>


                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>
                        {{-- @endifs --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Role Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header text-white" style="background:#FC5C14;">
                    <h5 class="modal-title" id="roleModalLabel">Role Info</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="roleModalBody">
                    <div class="text-center p-3">
                        <span class="spinner-border text-warning"></span> Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-role-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');

                    // Show modal with loading state
                    const modal = new bootstrap.Modal(document.getElementById('roleModal'));
                    modal.show();

                    document.getElementById('roleModalLabel').textContent = 'Loading...';
                    document.getElementById('roleModalBody').innerHTML = `
                    <div class="text-center p-3">
                        <span class="spinner-border text-warning"></span> Fetching data...
                    </div>`;

                    // Fetch role data
                    fetch(`/roles/${roleId}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('roleModalLabel').textContent =
                                'Role Info - ' + data.name;
                            document.getElementById('roleModalBody').innerHTML = `
                            <table class="table table-bordered table-striped text-start">
                                <tr><th>Name</th><td>${data.name}</td></tr>
                                <tr><th>Guard</th><td>${data.guard_name}</td></tr>
                                <tr><th>Status</th><td>${data.status}</td></tr>

                            </table>`;
                        })
                        .catch(err => {
                            document.getElementById('roleModalBody').innerHTML = `
                            <div class="alert alert-danger">Error loading data.</div>`;
                        });
                });
            });
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-role-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');

                    // Set loading content before showing modal
                    document.getElementById('roleModalLabel').textContent = 'Loading...';
                    document.getElementById('roleModalBody').innerHTML = `
                    <div class="text-center p-3">
                        <span class="spinner-border text-warning"></span> Fetching data...
                    </div>`;

                    // Fetch data first, then show modal
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

                            // Now show modal
                            const modal = new bootstrap.Modal(document.getElementById(
                                'roleModal'));
                            modal.show();
                        })
                        .catch(err => {
                            document.getElementById('roleModalBody').innerHTML = `
                            <div class="alert alert-danger">Error loading data.</div>`;
                            // Show modal anyway to display error
                            const modal = new bootstrap.Modal(document.getElementById(
                                'roleModal'));
                            modal.show();
                        });
                });
            });
        });
    </script>


@endsection
