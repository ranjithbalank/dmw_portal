@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        <span>{{ 'Edit Permission Assignment' }}</span>
                        <a href="{{ route('assign-unit-permissions.index') }}"
                            class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <form action="{{ route('assign-unit-permissions.update', $assignment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3 mt-3 px-3">
                            <div class="col-md-4">
                                <label for="role_id" class="form-label fw-bold">Select Role</label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $assignment->role_id == $role->id ? 'selected' : '' }}>
                                            {{ strtoupper($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="unit_id" class="form-label fw-bold">Select Unit</label>
                                <select class="form-select" id="unit_id" name="unit_id" required>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $assignment->unit_id == $unit->id ? 'selected' : '' }}>
                                            {{ strtoupper($unit->name) }} - {{ strtoupper($unit->code) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="module_id" class="form-label fw-bold">Select Module</label>
                                <select class="form-select" id="module_id" name="module_id" required>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}"
                                            {{ $assignment->module_id == $module->id ? 'selected' : '' }}>
                                            {{ strtoupper($module->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 px-3">
                            <h5 class="mt-3 fw-bold">Assign Permissions:</h5>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                id="permission_{{ $permission->id }}" name="permission_ids[]"
                                                value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $assignedPermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold"
                                                for="permission_{{ $permission->id }}">
                                                {{ ucfirst($permission->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>



                        <div class="card-footer bg-white d-flex justify-content-end px-3 py-3">
                            <button type="submit" class="btn btn-primary">
                                Update Permissions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
