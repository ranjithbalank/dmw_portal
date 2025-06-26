@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span>Leave Request Details</span>
                    <a href="{{ route('leaves.index') }}" class="btn btn-light btn-sm text-dark">← Back</a>
                </div>

                <div class="card-body">
                    <h5><strong>Employee:</strong> {{ $leave->user->name ?? 'N/A' }}</h5>
                    <h5><strong>Email:</strong> {{ $leave->user->email ?? 'N/A' }}</h5>
                    <hr>

                    <h5><strong>Leave Type:</strong> {{ ucfirst($leave->leave_type) }}</h5>
                    <h5><strong>Duration:</strong> {{ $leave->leave_duration }}</h5>
                    <h5><strong>From Date:</strong> {{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}</h5>
                    <h5><strong>To Date:</strong> {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</h5>
                    <h5><strong>Total Leave Days:</strong> {{ $leave->leave_days }}</h5>
                    <h5><strong>Leave Balance:</strong> {{ $leave->leave_days }}</h5>
                    <h5><strong>Status:</strong>
                        <span class="badge
                            @if($leave->status == 'approved') bg-success
                            @elseif($leave->status == 'rejected') bg-danger
                            @else bg-warning text-dark
                            @endif">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </h5>
                    <h5><strong>Reason:</strong></h5>
                    <p class="border rounded p-2">{{ $leave->reason }}</p>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('leaves.edit', $leave->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this leave request?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
