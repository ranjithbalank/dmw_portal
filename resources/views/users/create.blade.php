@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        <span>{{ 'Create User' }}</span>

                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>
                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            {{-- Row 1: Name, Employee ID, Email --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Full Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="employee_id" class="form-label">Employee ID <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                        name="employee_id" id="employee_id" value="{{ old('employee_id') }}" required>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 2: Unit, Department, Manager --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                        name="unit" id="unit" value="{{ old('unit') }}" required>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="department" class="form-label">Department <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror"
                                        name="department" id="department" value="{{ old('department') }}" required>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="manager_id" class="form-label">Reporting Manager ID <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('manager_id') is-invalid @enderror"
                                        name="manager_id" id="manager_id" value="{{ old('manager_id') }}" required>
                                    @error('manager_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 3: Work Designation --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="designation" class="form-label">Work Designation <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                        name="designation" id="designation" value="{{ old('designation') }}" required>
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="doj" class="form-label">Date of Join <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('doj') is-invalid @enderror"
                                        name="doj" id="doj" value="{{ old('doj') }}" required>
                                    @error('doj')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="type_emp" class="form-label">
                                        Type of Shift <span class="text-danger">*</span>
                                    </label>
                                    <select name="type_emp" id="type_emp"
                                        class="form-select @error('type_emp') is-invalid @enderror" required>
                                        <option value="">-- Select --</option>
                                        <option value="General" {{ old('type_emp') == 'General' ? 'selected' : '' }}>
                                            General</option>
                                        <option value="Shift" {{ old('type_emp') == 'Shift' ? 'selected' : '' }}>Shift
                                        </option>
                                    </select>
                                    @error('type_emp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="roles" class="form-label">Role <span
                                            class="text-danger">*</span></label>
                                    <select id="roles" name="roles[]" class="form-select select2" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 4: Password + Confirm Password --}}
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password-confirm" required>
                                </div>
                            </div>
                            {{-- Submit in Card Footer --}}

                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
