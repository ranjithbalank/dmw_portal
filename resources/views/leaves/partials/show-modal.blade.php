<div class="modal fade" id="leaveModal{{ $leave->id }}" tabindex="-1"
    aria-labelledby="leaveModalLabel{{ $leave->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header text-white" style="background:#FC5C14;">
                <h5 class="modal-title" id="leaveModalLabel{{ $leave->id }}">Leave Request - #{{ $leave->id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped text-start">
                    <tbody>
                        <tr>
                            <th>Employee</th>
                            <td class="text-primary fw-italic">
                                <em>{{ $leave->user?->name ?: '👤 Unknown User' }}</em>
                            </td>

                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $leave->user->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Leave Type</th>
                            <td>{{ ucfirst($leave->leave_type) }}</td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>{{ $leave->leave_duration }}</td>
                        </tr>
                        <tr>
                            <th>From / For Date</th>
                            <td><span style="color:blue">{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>To / Comp-Off Date</th>
                            <td><span style="color:blue">{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Leave Days</th>
                            <td>{{ $leave->leave_days }}</td>
                        </tr>
                        <tr>
                            <th>Leave Balance</th>
                            <td class="text-danger fw-bold">{{ $user->leave_balance }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span
                                    class="badge
                                    @if ($leave->status === 'approved') bg-success
                                    @elseif($leave->status === 'rejected') bg-danger
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Reason</th>
                            <td>{{ $leave->reason }}</td>
                        </tr>
                        <tr>
                            <th>Requested On</th>
                            <td>{{ $leave->created_at->format('d-m-Y H:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
