@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">{{ 'Register Employee' }}</div>

                    <div class="card-body py-3">

                        <form method="POST" action="{{ route('register') }}">
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
                                    <label for="employee_id" class="form-label">Employee ID
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                        name="employee_id" id="employee_id" value="{{ old('employee_id') }}" required>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
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
                                    <label for="unit" class="form-label">Unit<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                        name="unit" id="unit" value="{{ old('unit') }}" required>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="department" class="form-label">Department
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror"
                                        name="department" id="department" value="{{ old('department') }}" required>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="manager" class="form-label">Reporting Manager Id
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('manager') is-invalid @enderror"
                                        name="manager" id="manager" value="{{ old('manager') }}" required>
                                    @error('manager')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 3: Password + Confirm Password --}}
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password
                                        <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label">Confirm Password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password-confirm" required>
                                </div>
                            </div>

                    </div>
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ 'Register' }}
                                </button>

                                <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
                                    {{ 'Already registered? Click here to login' }}
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
