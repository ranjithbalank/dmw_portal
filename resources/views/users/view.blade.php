@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    User Profile
                </div>

                <div class="card-body">
                    <h5><strong>Name:</strong> {{ $user->name }}</h5>
                    <h5><strong>Email:</strong> {{ $user->email }}</h5>

                    <hr>

                    <h5><strong>Role:</strong> {{ $user->details->role ?? 'N/A' }}</h5>
                    <h5><strong>Status:</strong> {{ $user->details->status ?? 'N/A' }}</h5>
                    <h5><strong>Division:</strong> {{ $user->details->division ?? 'N/A' }}</h5>
                    <h5><strong>Div Code:</strong> {{ $user->details->divcode ?? 'N/A' }}</h5>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
