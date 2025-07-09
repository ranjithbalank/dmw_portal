@extends('layouts.app')

@section('title', 'Leave History')

{{-- DataTables CSS --}}
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="background:#FC5C14; color: white;">
                    Leave History
                    <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                </div>

                <div class="card-body">
                    {{-- View Tabs --}}
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->get('view') !== 'team' ? 'active' : '' }}"
                                href="{{ route('leaves.index', ['view' => 'mine']) }}">
                                My Leaves
                            </a>
                        </li>

                        @if (auth()->user()->hasAnyRole(['Manager', 'Admin', 'HR']))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->get('view') === 'team' ? 'active' : '' }}"
                                    href="{{ route('leaves.index', ['view' => 'team']) }}">
                                    {{ auth()->user()->hasRole('Admin') ? 'All Leaves' : 'Leave Approvals' }}
                                    @if (!empty($pendingCount) && $pendingCount > 0)
                                        <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    </ul>

                    {{-- Apply Leave --}}
                    @if (request()->get('view') !== 'team')
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('leaves.create') }}" class="btn btn-success shadow-sm">
                                <i class="bi bi-plus-circle"></i> Apply Leave
                            </a>
                        </div>
                    @endif

                    {{-- Table --}}
                    @if ($leaves->isEmpty())
                        <div class="alert alert-warning text-center">No leave records found.</div>
                    @else
                        <div class="table-responsive mb-4">
                            <table id="leaveTable"
                                class="table table-bordered table-striped table-hover text-center align-middle">
                                <thead class="text-center">
                                    <tr>
                                        <th>S.No</th>
                                        @if (request()->get('view') === 'team')
                                            <th>Employee</th>
                                        @endif
                                        <th>Leave</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
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
                                            @if (request()->get('view') === 'team')
                                                <td class="text-primary">{{ Str::ucfirst($leave->user->name ?? '-') }}</td>
                                            @endif
                                            <td class="text-capitalize text-danger text-start">{{ $leave->leave_type }}</td>
                                            <td>
                                                {{ $leave->leave_type === 'comp-off' && $leave->comp_off_worked_date
                                                    ? \Carbon\Carbon::parse($leave->comp_off_worked_date)->format('d M Y')
                                                    : ($leave->from_date
                                                        ? \Carbon\Carbon::parse($leave->from_date)->format('d M Y')
                                                        : '-') }}
                                            </td>
                                            <td>
                                                {{ $leave->leave_type === 'comp-off' && $leave->comp_off_leave_date
                                                    ? \Carbon\Carbon::parse($leave->comp_off_leave_date)->format('d M Y')
                                                    : ($leave->to_date
                                                        ? \Carbon\Carbon::parse($leave->to_date)->format('d M Y')
                                                        : '-') }}
                                            </td>
                                            <td>{{ ($leave->leave_days) }}</td>
                                            <td>{{ Ucfirst($leave->reason) }}</td>
                                            <td>
                                                @if ($leave->status == 'hr approved')
                                                    <span class="badge badge-wrap bg-success">{{strtoupper('HR Approved')}}</span>
                                                @elseif ($leave->status == 'hr rejected')
                                                    <span class="badge badge-wrap bg-danger">{{strtoupper('HR Rejected')}}</span>
                                                @elseif ($leave->status == 'supervisor/ manager approved')
                                                    <span class="badge badge-wrap bg-primary">{{strtoupper('Supervisor/ Manager Approved')}}</span>
                                                @elseif ($leave->status == 'supervisor/ manager rejected')
                                                    <span class="badge badge-wrap bg-danger">{{strtoupper('Supervisor/ Manager Rejected')}}</span>
                                                @elseif ($leave->status == 'pending')
                                                    <span class="badge badge-wrap bg-warning text-dark">{{strtoupper('Pending')}}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{strtoupper('Unknown')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if (auth()->user()->hasRole('Employee') && auth()->id() === $leave->user_id)
                                                        <a href="{{ route('leaves.edit', $leave->id) }}"
                                                            class="btn btn-sm btn-primary me-1">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-info me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#leaveModal{{ $leave->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    @if (auth()->user()->hasRole('Admin'))
                                                        <form action="{{ route('leaves.destroy', $leave->id) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?');"
                                                            style="display:inline-block; margin:0; padding:0;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                                @include('leaves.partials.show-modal', [
                                                    'leave' => $leave,
                                                    'user' => $leave->user ?? null,
                                                ])
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

{{-- DataTables JS --}}
@section('scripts')
<script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#leaveTable').DataTable({
            "order": [],  // disable initial ordering
            "pageLength": 10
        });
    });
</script>
@endsection
