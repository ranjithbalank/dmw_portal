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

                        <div class="table-responsive mb-4">
                            <table id="departmentTable" class="table table-bordered text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Code</th>
                                        <th>Department Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($department as $index => $departments)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">{{ ucfirst($departments->code) }}</td>
                                            <td class="text-start">{{ ucfirst($departments->name) }}</td>
                                            <td class="text-center">
                                                @if ($departments->status == 'inactive')
                                                    <span class="btn btn-sm btn-danger fw-bold">{{ ucfirst($departments->status) }}</span>
                                                @else
                                                    <span class="btn btn-sm btn-success fw-bold">{{ ucfirst($departments->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('roles.edit', $departments->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                {{-- <button type="button" class="btn btn-info btn-sm view-role-btn"
                                                    data-role-id="{{ $departments->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button> --}}
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
        $(document).ready(function () {
            $('#departmentTable').DataTable({
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
                            document.getElementById('roleModalLabel').textContent = 'Role Info - ' + data.name;
                            document.getElementById('roleModalBody').innerHTML = `
                            <table class="table table-bordered table-striped text-start">
                                <tr><th>Name</th><td>${data.name}</td></tr>
                                <tr><th>Guard</th><td>${data.guard_name}</td></tr>
                                <tr><th>Status</th><td>${data.status ?? 'Active'}</td></tr>
                            </table>`;

                            const modal = new bootstrap.Modal(document.getElementById('roleModal'));
                            modal.show();
                        })
                        .catch(err => {
                            document.getElementById('roleModalBody').innerHTML = `
                            <div class="alert alert-danger">Error loading data.</div>`;

                            const modal = new bootstrap.Modal(document.getElementById('roleModal'));
                            modal.show();
                        });
                });
            });
        });
    </script>
@endsection
