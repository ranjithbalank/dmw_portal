@extends('layouts.app')

@section('title', 'Leave History')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        Leave History
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('leaves.create') }}" class="btn btn-success shadow-sm">
                                <i class="bi bi-plus-circle"></i> Apply Leave
                            </a>
                        </div>



                        @if ($leaves->isEmpty())
                            <div class="alert alert-warning text-center">No leave records found.</div>
                        @else
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Days</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaves as $index => $leave)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-capitalize">{{ $leave->leave_type }}</td>
                                                <td>{{ $leave->leave_duration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</td>
                                                <td>{{ $leave->leave_days }}</td>
                                                <td>{{ $leave->reason }}</td>
                                                <td>
                                                    @if ($leave->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($leave->status == 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('leaves.edit', $leave->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <!-- View Button to trigger modal -->

                                                    <!-- Trigger Button -->
                                                    <button type="button" class="btn btn-info btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#leaveModal{{ $leave->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>

                                                    <!-- Include the modal -->
                                                    @include('leaves.partials.show-modal', [
                                                        'user' => $user,
                                                    ])

                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        style="display: inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
