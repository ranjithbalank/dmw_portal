@extends('layouts.app') <!-- remove this if you don’t use a layout -->

@section('content')
    @hasrole('Admin')
        {{-- Allow HR or Admin --}}
        <div class="container">
            <h4 class="mb-3">Import Employees from Excel</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
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
    @else
        <div class="text-center mt-5">
            <img src="https://img.icons8.com/emoji/96/warning-emoji.png" alt="Warning" width="100" class="mb-3">
            <div class="alert alert-danger">
                🚫 You are not authorized to access this page.
            </div>
        </div>
    @endhasrole
@endsection
