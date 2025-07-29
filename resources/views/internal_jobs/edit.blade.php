@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        <span>{{ 'Edit Job Posting' }}</span>

                        <a href="{{ route('internal-jobs.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">←
                            Back</a>
                    </div>
                    <div class="card-body py-3">
                        <form method="POST" action="{{ route('internal-jobs.update', $jobs->id) }}">
                            @csrf
                            @method('PUT')
                            {{-- @dd($jobs); --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="job_id" class="form-label">Job ID <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('job_id') is-invalid @enderror"
                                        name="job_id" id="job_id" value="{{ old('job_id', $jobs->id) }}" readonly>
                                    @error('job_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="job_title" class="form-label">Job Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('job_title') is-invalid @enderror"
                                        name="job_title" id="job_title" value="{{ old('job_title', $jobs->job_title) }}"
                                        required>
                                    @error('job_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="job_description" class="form-label">Job Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('job_description') is-invalid @enderror" name="job_description"
                                        id="job_description" required>{{ old('job_description', $jobs->job_description) }}</textarea>
                                    @error('job_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="slot_available" class="form-label">Slots Available <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('slot_available') is-invalid @enderror"
                                        name="slot_available" id="slot_available"
                                        value="{{ old('slot_available', $jobs->slot_available) }}" required>
                                    @error('slot_available')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="qualification" class="form-label">Qualification <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('qualification') is-invalid @enderror"
                                        name="qualification" id="qualification"
                                        value="{{ old('qualification', $jobs->qualifications) }}" required>
                                    @error('qualification')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="work_experience" class="form-label">Work Experience <span
                                            class="text-danger">*</span></label>
                                    <input type="text" step="0.1"
                                        class="form-control @error('work_experience') is-invalid @enderror"
                                        name="work_experience" id="work_experience"
                                        value="{{ old('work_experience', $jobs->work_experience) }}" required>
                                    @error('work_experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                        name="unit" id="unit" value="{{ old('unit', $jobs->unit) }}" required>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="division" class="form-label">Division <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('division') is-invalid @enderror"
                                        name="division" id="division"
                                        value="{{ old('division', ucfirst(strtolower($jobs->division))) }}" required>
                                    @error('division')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">-- Select --</option>
                                        <option value="active"
                                            {{ old('status', $jobs->first()->status) == 'active' ? 'selected' : '' }}>Open
                                        </option>
                                        <option value="closed" {{ old('status', $jobs->first()->status) == 'closed' ? 'selected' : '' }}>
                                            Registration Closed
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $jobs->first()->status) == 'inactive' ? 'selected' : '' }}>
                                            Closed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="passing_date" class="form-label">Opening Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        name="passing_date" id="passing_date"
                                        value="{{ old('passing_date', $jobs->passing_date) }}" required>
                                    @error('passing_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">End Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        name="end_date" id="end_date" value="{{ old('end_date', $jobs->end_date) }}"
                                        required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
