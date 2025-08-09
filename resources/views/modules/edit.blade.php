@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4">
        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                <span>Edit Module</span>
                <a href="{{ route('modules.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
            </div>

            <div class="card-body">
                {{-- Form for editing an existing module --}}
                <form action="{{ route('modules.update', $module->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Module Name</label>
                        <input type="text" class="form-control w-25 @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $module->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Add more fields as necessary for editing --}}

                    <button type="submit" class="btn btn-primary">Update Module</button>
                </form>
            </div>
        </div>
    </div>
@endsection
