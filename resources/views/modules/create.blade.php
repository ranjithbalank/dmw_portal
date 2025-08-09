@extends('layouts.app')
@section('content')
    <div class="container-fluid pt-4">
        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">

                <span>Create Module</span>
                <a href="{{ route('modules.index') }}" class="btn btn-light btn-sm text-dark shadow-sm"><- Back</a>
            </div>

            <div class="card-body">
                {{-- Form for creating a new module --}}
                <form action="{{ route('modules.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Module Name</label>
                        <input type="text" class="form-control w-25" id="name" name="name" required>
                    </div>
                    {{-- Add more fields as necessary --}}
                    <button type="submit" class="btn btn-success">Create Module</button>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- @dd('Create Module Form'); --}}
