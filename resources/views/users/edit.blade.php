@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        <span>Edit User</span>
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Row 1 --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    @hasrole(['Admin', 'HR'])
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" required>
                                    @else
                                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                    @endhasrole
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" value="{{ $user->employee_id }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    @hasrole(['Admin', 'HR'])
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" required>
                                    @else
                                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                    @endhasrole
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" class="form-control" value="{{ $user->unit }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" value="{{ $user->department }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label for="manager_id" class="form-label">Manager</label>
                                    <input type="text" class="form-control" value="{{ $user->manager?->name }}" disabled>
                                </div>
                            </div>

                            {{-- Row 3 --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control" value="{{ $user->designation }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label for="doj" class="form-label">Date of Join <span class="text-danger">*</span></label>
                                    @hasrole(['Admin', 'HR'])
                                        <input type="date" class="form-control @error('doj') is-invalid @enderror"
                                            name="doj" id="doj" value="{{ $user->doj ? $user->doj->format('Y-m-d') : '' }}" required>
                                    @else
                                        <input type="date" class="form-control" value="{{ $user->doj ? $user->doj->format('Y-m-d') : '' }}" disabled>
                                    @endhasrole
                                    @error('doj')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="type_emp" class="form-label">Type of Shift <span class="text-danger">*</span></label>
                                    @hasrole(['Admin', 'HR'])
                                        <select name="type_emp" id="type_emp" class="form-select @error('type_emp') is-invalid @enderror" required>
                                            <option value="General" {{ old('type_emp', $user->type_emp) == 'General' ? 'selected' : '' }}>General</option>
                                            <option value="Shift" {{ old('type_emp', $user->type_emp) == 'Shift' ? 'selected' : '' }}>Shift</option>
                                        </select>
                                    @else
                                        <input type="text" class="form-control" value="{{ $user->type_emp }}" disabled>
                                    @endhasrole
                                    @error('type_emp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="roles" class="form-label">Role <span class="text-danger">*</span></label>
                                    @hasrole(['Admin', 'HR'])
                                        <select name="roles[]" id="roles" class="form-select select2" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control" value="{{ $user->roles->pluck('name')->first() }}" disabled>
                                    @endhasrole
                                    @error('roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    @hasrole(['Admin', 'HR'])
                                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    @else
                                        <input type="text" class="form-control" value="{{ ucfirst($user->status) }}" disabled>
                                    @endhasrole
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 4 --}}
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">New Password (optional)</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Leave blank to keep current">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                    </div>

                    {{-- Submit --}}
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
