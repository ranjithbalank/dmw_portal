<div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-labelledby="userModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header text-white"
            style="background:#FC5C14; color: white;">
                <h5 class="modal-title" id="userModalLabel{{ $user->id }}">User Profile - {{ $user->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
            </div>

        </div>
    </div>
</div>
