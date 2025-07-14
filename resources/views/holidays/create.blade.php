@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        {{ 'Add Holiday' }}
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

                        <form action="{{ route('holidays.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Holiday Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter holiday name"
                                    value="{{ old('name') }}" autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Holiday Date</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date') }}">
                            </div>

                            {{-- Close form tags AFTER card-footer --}}
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary shadow-sm">Save</button>

                    </div>

                    </form> {{-- form ends here --}}
                </div>
            </div>
        </div>
    </div>
@endsection
