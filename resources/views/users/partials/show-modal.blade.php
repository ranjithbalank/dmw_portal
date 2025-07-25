<div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-labelledby="userModalLabel{{ $user->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header text-white" style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                <h5 class="modal-title" id="userModalLabel{{ $user->id }}">User Profile - {{ $user->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            {{-- <div class="modal-body">
                <table class="table table-bordered table-striped text-start">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ $user->designation ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ Str::ucfirst($user->status) ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Unit</th>
                            <td>{{ $user->unit ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{ $user->department ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Join</th>
                            <td>{{ $user->doj->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $user->created_at->format('d-m-Y H:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
            <!-- Modal Body -->
            <div class="modal-body px-4 py-3">
                <!-- Top Avatar & Basic Info -->
                <div class="text-center mb-4">
                    <div class="d-inline-block position-relative">
                        <i class="bi bi-person-circle" style="font-size: 5rem; color: #f7b733;"></i>
                    </div>
                    <h4 class="mt-3 mb-1">{{ $user->name }}</h4>
                    <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                        <strong>Employee ID:</strong> {{ $user->employee_id ?? 'N/A' }}
                    </p>
                    <p class="text-muted" style="font-size: 0.95rem;">{{ $user->email }}</p>
                    <hr>
                </div>

                <!-- Info Grid -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Designation</p>
                            <h6 class="mb-0">{{ $user->designation ?? 'N/A' }}</h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Unit</p>
                            <h6 class="mb-0">{{ $user->unit ?? 'N/A' }}</h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Division</p>
                            <h6 class="mb-0">{{ $user->department ?? 'N/A' }}</h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Date of Joining</p>
                            <b>{{ $user->doj ? \Carbon\Carbon::parse($user->doj)->format('d M Y') : 'N/A' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Shift</p>
                            <b>{{ $user->type_emp ?? 'N/A' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Manager</p>
                            <b>{{ $user->manager?->name ?? 'N/A' }}</b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Last Login</p>
                            <b>
                                {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d M Y, h:i A') : 'N/A' }}
                            </b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Last Logout</p>
                            <b>
                                {{ $user->last_logout_at ? \Carbon\Carbon::parse($user->last_logout_at)->format('d M Y, h:i A') : 'N/A' }}
                            </b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="text-muted mb-1">Status</p>
                            <b>
                                @if ($user->status === 'active')
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
