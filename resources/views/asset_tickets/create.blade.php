@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        {{ 'Facility Ticket History' }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>
<div class="container">

    <h2>Create New Ticket</h2>

    <form method="POST" action="{{ route('asset-tickets.store') }}">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Category ID</label>
            <input type="number" name="category_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Priority</label>
            <select name="priority" class="form-control" required>
                <option>Very Urgent</option>
                <option>Urgent</option>
                <option>Very High</option>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Unit</label>
            <input name="unit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Division</label>
            <input name="division" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create Ticket</button>
        <a href="{{ route('asset-tickets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
