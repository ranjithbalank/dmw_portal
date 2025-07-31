@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        <span>Create Circular</span>
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Error Message --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('circulars.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    {{-- Circular Number --}}
                                    <div class="col-md-4 mb-3">
                                        <label for="circular_number" class="form-label">Circular Number / Name </label>
                                        <input type="text" name="circular_number" id="circular_number"
                                            class="form-control @error('circular_number') is-invalid @enderror"
                                            value="{{ old('circular_number') }}" required>
                                        @error('circular_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Date of Circular --}}
                                    <div class="col-md-4 mb-3">
                                        <label for="circular_date" class="form-label">Date of Circular</label>
                                        <input type="date" name="circular_date" id="circular_date"
                                            class="form-control @error('circular_date') is-invalid @enderror"
                                            value="{{ old('circular_date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                            required>
                                        @error('circular_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Created By --}}
                                    <div class="col-md-4 mb-3">
                                        <label for="created_by" class="form-label">Created By</label>
                                        <input type="text" name="created_by" id="created_by" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                {{-- File Upload --}}
                                <div class="mb-3">
                                    <label for="circular_file" class="form-label">Upload Circular (PDF only)</label>
                                    <input type="file" name="circular_file" id="circular_file"
                                        class="form-control @error('circular_file') is-invalid @enderror" accept=".pdf"
                                        required>
                                    @error('circular_file')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            </div>

                            {{-- Submit Button --}}

                            {{-- Upload Button in Card Footer --}}
                            <div class="card-footer text-end bg-light">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Upload Circular
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
