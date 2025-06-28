@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color:white;">
                        {{ __('Edit Holiday') }}
                        <a href="{{ route('holidays.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Please fix the following errors:<br><br>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('holidays.update', $holiday->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Holiday Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $holiday->name) }}">
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Holiday Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', $holiday->date) }}">
                            </div>

                            <button type="submit" class="btn btn-primary shadow-sm">Update</button>
                            <a href="{{ route('holidays.index') }}" class="btn btn-secondary shadow-sm">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
