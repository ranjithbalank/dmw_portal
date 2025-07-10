@extends('layouts.app') <!-- remove this if you don’t use a layout -->

@section('content')
<div class="container">
    <h4 class="mb-3">Import Employees from Excel</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Choose Excel file (.xlsx or .csv)</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Import Employees</button>
    </form>
</div>
@endsection
