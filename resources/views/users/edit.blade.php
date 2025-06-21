@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        <span>{{ __('Edit User') }}</span>
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Name & Email --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Name</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password & Confirm --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Password cannot be seen here">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Role, Status & Div Code --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="role" class="form-label fw-bold">Role</label>
                                    <select id="status" name="status" class="form-select select2" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select id="status" name="status" class="form-select select2" required>
                                        <option value="active"
                                            {{ ($user->details->status ?? '') === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ ($user->details->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="divcode" class="form-label fw-bold">Div Code</label>
                                    <input type="text" id="divcode" name="divcode" class="form-control"
                                        value="{{ old('divcode', $user->details->divcode ?? '') }}">
                                </div>
                            </div>

                            {{-- Division --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="division" class="form-label fw-bold">Division</label>
                                    <input type="text" id="division" name="division" class="form-control"
                                        value="{{ old('division', $user->details->division ?? '') }}">
                                </div>
                            </div>

                            {{-- Submit --}}
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
