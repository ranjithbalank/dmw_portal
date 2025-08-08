@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(90deg, #36d1dc, #5b86e5);">
                    <span><strong>Unit Permissions for {{ ucfirst($role->name) }}</strong></span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-light shadow-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#permissionsTable" aria-expanded="true" aria-controls="permissionsTable">
                            Toggle Table
                        </button>
                        <a href="{{ route('assign-unit-permissions.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Flash success message (if redirected after update) --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('assign-unit-permissions.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Permissions Table -->
                        <div class="table-responsive collapse show" id="permissionsTable">
                            <h5 class="mb-3">Edit Permissions</h5>
                            <table class="table table-bordered text-center align-middle table-hover">
                                <thead class="table-light text-primary">
                                    <tr>
                                        <th class="text-start">Permission</th>
                                        <th>ALL</th>
                                        @foreach ($units as $unit)
                                            <th>{{ strtoupper($unit->code) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $perm)
                                        <tr>
                                            <td class="text-start fw-semibold">{{ ucfirst($perm->name) }}</td>
                                            <td>
                                                <input type="checkbox"
                                                    class="form-check-input select-all"
                                                    data-permission="{{ $perm->name }}">
                                            </td>

                                            @foreach ($units as $unit)
                                                @php
                                                    $checked = $existingPermissions->contains(function ($val) use ($unit, $perm) {
                                                        return $val->unit_id == $unit->id && $val->permission== $perm->name;
                                                    });
                                                @endphp
                                                <td>
                                                    <input type="checkbox"
                                                        name="permissions[{{ $unit->id }}][{{ $perm->name }}]"
                                                        value="1"
                                                        class="form-check-input perm-checkbox perm-{{ $perm->name }}"
                                                        {{ $checked ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success px-4">
                                Update Permissions
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Handle select-all per permission row
        document.querySelectorAll(".select-all").forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const permission = this.dataset.permission;
                const checkboxes = document.querySelectorAll(".perm-" + permission);
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        });
    });
</script>
@endsection
