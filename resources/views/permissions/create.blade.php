@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        <span>{{ __('Create Permissions') }}</span>
                        <a href="{{ route('permissions.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('permissions.store') }}">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Permission Name</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="guardname" class="form-label fw-bold">Guard Name</label>
                                    <select id="guardname" name="guardname"
                                        class="form-select select2 @error('guardname') is-invalid @enderror" required>
                                        <option value="">-- Select --</option>
                                        <option value="web" {{ old('guardname') == 'web' ? 'selected' : '' }}>web
                                        </option>
                                        <option value="api" {{ old('guardname') == 'api' ? 'selected' : '' }}>api
                                        </option>
                                        <!-- Add more if needed -->
                                    </select>
                                    @error('guardname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="status" id="status"
                                        class="form-select select2 @error('status') is-invalid @enderror" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
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
