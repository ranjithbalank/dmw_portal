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

                            @if (auth()->user()->hasAnyRole(['Manager', 'Admin','HR']))
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
                                <table class="table table-bordered table-striped table-hover text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S.No</th>
                                            @if (request()->get('view') === 'team')
                                                <th>Employee</th>
                                            @endif
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>From / Worked </th>
                                            <th>To / Comp off </th>
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
                                                    <td class="text-primary">{{ $leave->user->name ?? '-' }}</td>
                                                @endif

                                                <td class="text-capitalize text-danger text-start">{{ $leave->leave_type }}
                                                </td>
                                                <td>{{ $leave->leave_duration }}</td>
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
                                                <td>{{ $leave->leave_days }}</td>
                                                <td>{{ $leave->reason }}</td>
                                                <td>
                                                    @if ($leave->status == 'hr approved')
                                                        <span class="badge bg-success">HR Approved</span>
                                                    @elseif ($leave->status == 'hr rejected')
                                                        <span class="badge bg-danger">HR Rejected</span>
                                                    @elseif ($leave->status == 'supervisor/ manager approved')
                                                        <span class="badge bg-primary">Supervisor/ Manager Approved</span>
                                                    @elseif ($leave->status == 'supervisor/ manager rejected')
                                                        <span class="badge bg-danger">Supervisor/ Manager Rejected</span>
                                                    @elseif ($leave->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @else
                                                        <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        {{-- Edit: Only Employee can edit their own leave --}}
                                                        @if (auth()->user()->hasRole('Employee') && auth()->id() === $leave->user_id)
                                                            <a href="{{ route('leaves.edit', $leave->id) }}"
                                                                class="btn btn-sm btn-primary me-1">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                        @endif

                                                        {{-- View Button --}}
                                                        <button type="button" class="btn btn-sm btn-info me-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#leaveModal{{ $leave->id }}">
                                                            <i class="bi bi-eye"></i>
                                                        </button>

                                                        {{-- Approve / Reject --}}
                                                        {{-- @if (request()->get('view') === 'team' && auth()->user()->hasRole('Manager') && $leave->status === 'pending' && auth()->user()->employee_id === optional($leave->user)->manager_id)
                                                            <form
                                                                action="{{ route('leaves.manager.approve', $leave->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Do you really want to approve this record as Manager?');"
                                                                style="display:inline-block;" class="me-1">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success"
                                                                    title="Manager Approve">
                                                                    <i class="bi bi-check-circle"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('leaves.hr.approve', $leave->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Do you really want to approve this record as HR?');"
                                                                style="display:inline-block;" class="me-1">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-primary"
                                                                    title="HR Approve">
                                                                    <i class="bi bi-check-circle-fill"></i>
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('leaves.manager.reject', $leave->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Do you really want to Reject this record?');"
                                                                style="display:inline-block;" class="me-1">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-warning text-white"
                                                                    title="Reject">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('leaves.hr.reject', $leave->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Do you really want to Reject this record?');"
                                                                style="display:inline-block;" class="me-1">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-warning text-white"
                                                                    title="Reject">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            </form>
                                                        @endif --}}
                                                        @if (request()->get('view') === 'team')
                                                            {{-- Manager can approve/reject if status is pending and he is the manager --}}
                                                            {{-- @if (auth()->user()->hasRole('Manager') &&
                                                                    $leave->status === 'pending' &&
                                                                    auth()->user()->employee_id === optional($leave->user)->manager_id) --}}
                                                                {{-- <form
                                                                    action="{{ route('leaves.manager.approve', $leave->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Approve as Manager?');"
                                                                    style="display:inline-block;" class="me-1">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-success"
                                                                        title="Manager Approve">
                                                                        <i class="bi bi-check-circle"></i>
                                                                    </button>
                                                                </form> --}}
                                                                {{-- <form
                                                                    action="{{ route('leaves.manager.reject', $leave->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Reject as Manager?');"
                                                                    style="display:inline-block;" class="me-1">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-warning text-white"
                                                                        title="Manager Reject">
                                                                        <i class="bi bi-x-circle"></i>
                                                                    </button>
                                                                </form> --}}
                                                            {{-- @endif --}}

                                                            {{-- HR can approve/reject if status is supervisor/ manager approved --}}
                                                            {{-- @if (auth()->user()->hasRole('HR') && $leave->status === 'supervisor/ manager approved')
                                                                <form action="{{ route('leaves.hr.approve', $leave->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Approve as HR?');"
                                                                    style="display:inline-block;" class="me-1">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                                        title="HR Approve">
                                                                        <i class="bi bi-check-circle-fill"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('leaves.hr.reject', $leave->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Reject as HR?');"
                                                                    style="display:inline-block;" class="me-1">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-warning text-white"
                                                                        title="HR Reject">
                                                                        <i class="bi bi-x-circle"></i>
                                                                    </button>
                                                                </form>
                                                            @endif --}}
                                                        @endif


                                                        {{-- Delete: Only Admin --}}
                                                        @if (auth()->user()->hasRole('Admin'))
                                                            <form action="{{ route('leaves.destroy', $leave->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure?');"
                                                                style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>

                                                    {{-- Modal View --}}
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
