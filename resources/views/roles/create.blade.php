@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background:#FC5C14; color: white;">
                    <span>{{"Create Role"}}</span>
                    <a href="{{ route('roles.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="row mb-4">
                            <!-- Role Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Role Name</label>
                                {{-- <select class="form-select select2" name="roles[]">
                                        <option><-Select Role-></option>
                                        @foreach ($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select> --}}
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required>
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
                                    <option value="web" {{ old('guardname') == 'web' ? 'selected' : '' }}>web</option>
                                    <option value="api" {{ old('guardname') == 'api' ? 'selected' : '' }}>api</option>
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
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                                        {{ is_array(old('permission_id')) && in_array($permission->id, old('permission_id')) ? 'checked' : '' }}>
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
                            <button type="submit" class="btn btn-primary px-4">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
