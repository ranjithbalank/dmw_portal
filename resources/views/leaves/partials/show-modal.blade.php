<div class="modal fade" id="leaveModal{{ $leave->id }}" tabindex="-1"
    aria-labelledby="leaveModalLabel{{ $leave->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header text-white" style="background:#FC5C14;">
                <h5 class="modal-title" id="leaveModalLabel{{ $leave->id }}">Leave Request - {{ $leave->id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- ✅ Leave details --}}
                <table class="table table-bordered table-striped text-start mb-3">
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
                            <td>
                                @if ($leave->leave_type == 'N/A')
                                    <span class="text-danger">{{ 'Waiting For HR Decision' }}</span>
                                @else
                                    {{ ucfirst($leave->leave_type) }}
                                @endif
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>Duration</th>
                            <td>{{ $leave->leave_duration }}</td>
                        </tr> --}}
                        <tr>
                            <th>From Date</th>
                            <td style="color:blue">{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>To Date</th>
                            <td style="color:blue">{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Leave Days</th>
                            <td>{{ $leave->leave_days }} </td>
                        </tr>
                        {{-- <tr>
                            <th>Leave Balance</th>
                            <td class="text-danger fw-bold">{{ $user->leave_balance }}</td>
                        </tr> --}}
                        <tr>
                            <th>Status</th>
                            <td>
                                <span
                                    class="badge
                                    @if (str_contains($leave->status, 'approved')) bg-success
                                    @elseif(str_contains($leave->status, 'rejected')) bg-danger
                                    @else bg-warning text-dark @endif">
                                    {{ strtoupper($leave->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Reason</th>
                            <td>{{ Str::ucfirst($leave->reason) }}</td>
                        </tr>
                        <tr>
                            <th>Requested On</th>
                            <td>{{ $leave->created_at->format('d-m-Y H:i A') }}</td>
                        </tr>
                    </tbody>
                </table>

                {{-- ✅ Previous approvals/comments --}}
                <div class="mb-3">
                    <div class="row g-3">
                        @if ($leave->approver_1)
                            <div class="col-md-6">
                                <div class="card border-success h-100">
                                    <div class="card-body text-start p-3">
                                        <strong><em> Supervisor/Manager Name: </em></strong>
                                        <b> <span class="text-primary">Mr. / Ms. {{ $leave->approver1->name }}</span></b>
                                        <small class="text-muted d-block mt-2">
                                            Approved At:
                                            <b>{{ \Carbon\Carbon::parse($leave->approver_1_approved_at)->format('d-m-Y H:i A') }}</b>
                                        </small>
                                        <div class="mt-1">
                                            Approval Comments: <b>{{ $leave->approver_1_comments }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($leave->approver_2)
                            <div class="col-md-6">
                                <div class="card border-primary h-100">
                                    <div class="card-body text-start p-3">
                                        <strong><em> HR Name: </em></strong>
                                        <b> <span class="text-primary">Mr. / Ms. {{ $leave->approver2?->name ?? 'N/A' }}</span></b>
                                        <small class="text-muted d-block mt-2">
                                            Approved At:
                                            <b>{{ \Carbon\Carbon::parse($leave->approver_2_approved_at)->format('d-m-Y H:i A') }}</b>
                                        </small>
                                        <div class="mt-1">
                                            Approval Comments: <b>{{ $leave->approver_2_comments }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ✅ Manager approval form --}}
                @if (auth()->user()->hasRole('Manager') && $leave->status === 'pending')
                    <form action="{{ route('leaves.manager.decision', $leave) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <textarea name="comment" class="form-control" placeholder="Manager comment" rows="2" required></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">
                                ✅ Approve
                            </button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">
                                ❌ Reject
                            </button>
                        </div>
                    </form>
                @endif

                {{-- ✅ HR approval form --}}
                {{-- @if (auth()->user()->hasRole('HR') && $leave->status === 'supervisor/ manager approved')
                    <form action="{{ route('leaves.hr.decision', $leave) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <textarea name="comment" class="form-control" placeholder="HR comment" rows="2" required></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">
                                ✅ Approve
                            </button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">
                                ❌ Reject
                            </button>
                        </div>
                    </form>
                @endif --}}
                {{-- ✅ HR approval form --}}
                @if (auth()->user()->hasRole('HR') && $leave->status === 'supervisor/ manager approved')
                    <form action="{{ route('leaves.hr.decision', $leave) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <textarea name="comment" class="form-control" placeholder="HR comment" rows="2" required></textarea>
                        </div>

                        {{-- ✅ HR can optionally change leave type --}}
                        <div class="mb-2">
                            <label class="form-label">Change Leave Type </label>
                            <select name="leave_type" class="form-select">
                                <option value="casual">Casual</option>
                                <option value="sick">Sick</option>
                                <option value="earned">Earned</option>
                                <option value="comp-off">Comp-Off</option>
                                <option value="od">On Duty</option>
                                <option value="permission">Permission</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">
                                ✅ Approve
                            </button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">
                                ❌ Reject
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>
