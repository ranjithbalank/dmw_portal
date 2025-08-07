@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        <span>Create Department</span>
                        <a href="{{ route('unit.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('departments.store') }}">
                            @csrf
                            <div class="row mb-4">
                                <!-- Unit Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Department  Name</label>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Unit Code -->
                                <div class="col-md-6">
                                    <label for="code" class="form-label fw-bold">Department Code</label>
                                    <input id="code" type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           name="code" value="{{ old('code') }}" required>
                                    @error('code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
