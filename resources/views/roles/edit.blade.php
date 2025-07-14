@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        <span>{{ __('Edit Role') }}</span>
                        <a href="{{ route('roles.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('roles.update', $role->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-4">
                                <!-- Role Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Role Name</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $role->name }}" readonly>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Guard Name -->
                                <div class="col-md-6">
                                    <label for="guardname" class="form-label fw-bold">Guard Name</label>
                                    <select id="guardname" name="guardname"
                                        class="form-select select2 @error('guardname') is-invalid @enderror" required>
                                        <option value="">-- Select --</option>
                                        <option value="web"
                                            {{ old('guardname', $role->guard_name) == 'web' ? 'selected' : '' }}>web
                                        </option>
                                        <option value="api"
                                            {{ old('guardname', $role->guard_name) == 'api' ? 'selected' : '' }}>api
                                        </option>
                                    </select>
                                    @error('guardname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mt-3">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="status" id="status"
                                        class="form-select select2 @error('status') is-invalid @enderror" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="active"
                                            {{ old('status', $role->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive"
                                            {{ old('status', $role->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Permissions Table -->
                                <div class="col-md-12 mt-4">
                                    <label class="form-label fw-bold">Permission List</label>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px;">#</th>
                                                <th>Permission Name</th>
                                                <th style="width: 100px;">Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($permissions as $index => $permission)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="permission_id[]"
                                                            value="{{ $permission->id }}"
                                                            id="permission_{{ $permission->id }}"
                                                            {{ in_array($permission->id, old('permission_id', $rolePermissions)) ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">No permissions found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    @error('permission_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
