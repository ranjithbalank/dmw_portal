@extends('layouts.app')

@section('title', 'Roles List')

{{-- @section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background:#FC5C14; color:white;">
                Roles & Permissions
                <a href="{{ route('roles.create') }}" class="btn btn-light btn-sm text-dark shadow-sm">+ Add Role</a>
            </div>

            <<div class="table-responsive mb-4">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Role Name</th>
                            <th>Permission</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-uppercase">{{ $role->name }}</td>
                                <td>
                                    @if ($role->permissions->count())
                                        <span class="badge bg-success">Permission Created</span>
                                    @else
                                        <span class="badge bg-danger">No Permissions</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">
                                                    <i class="bi bi-pencil-square text-primary"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure to delete this role?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <div class="d-flex justify-content-end mt-3">
                    {{ $roles->links() }}
                </div>
        </div>
    </div>
    </div>
@endsection --}}

{{-- @section('scripts')
    <script>
        $(document).ready(function() {
            $('#rolesTable').DataTable({
                paging: false, // Laravel handles it
                ordering: true,
                info: false,
                searching: true
            });
        });
    </script>
@endsection --}}
