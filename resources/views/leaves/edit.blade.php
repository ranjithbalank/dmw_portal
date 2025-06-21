@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        <span>{{ __('Edit Leave Request') }}</span>
                        <a href="{{ route('leaves.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('leaves.update', $leave->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Leave Type & Duration --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_type" class="form-label fw-bold">Leave Type</label>
                                    <select name="leave_type" id="leave_type" class="form-select" required>
                                        <option value="casual" {{ $leave->leave_type === 'casual' ? 'selected' : '' }}>Casual</option>
                                        <option value="sick" {{ $leave->leave_type === 'sick' ? 'selected' : '' }}>Sick</option>
                                        <option value="earned" {{ $leave->leave_type === 'earned' ? 'selected' : '' }}>Earned</option>
                                    </select>
                                    @error('leave_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="leave_duration" class="form-label fw-bold">Duration</label>
                                    <select name="leave_duration" id="leave_duration" class="form-select" required>
                                        <option value="Full Day" {{ $leave->leave_duration === 'Full Day' ? 'selected' : '' }}>Full Day</option>
                                        <option value="Half Day" {{ $leave->leave_duration === 'Half Day' ? 'selected' : '' }}>Half Day</option>
                                    </select>
                                    @error('leave_duration')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- From & To Date --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="from_date" class="form-label fw-bold">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="{{ old('from_date', $leave->from_date) }}" required>
                                    @error('from_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="to_date" class="form-label fw-bold">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ old('to_date', $leave->to_date) }}" required>
                                    @error('to_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Leave Days --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_days" class="form-label fw-bold">No. of Leave Days</label>
                                    <input type="number" step="0.5" min="0" name="leave_days" id="leave_days" class="form-control"
                                        value="{{ old('leave_days', $leave->leave_days) }}" required>
                                    @error('leave_days')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Reason --}}
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="reason" class="form-label fw-bold">Reason</label>
                                    <textarea name="reason" id="reason" rows="3" class="form-control" required>{{ old('reason', $leave->reason) }}</textarea>
                                    @error('reason')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="pending" {{ $leave->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $leave->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $leave->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        function calculateLeaveDays() {
            const fromDate = new Date($('#from_date').val());
            const toDate = new Date($('#to_date').val());
            const duration = $('#leave_duration').val();

            if (!isNaN(fromDate) && !isNaN(toDate) && fromDate <= toDate) {
                let diff = Math.floor((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;
                let leaveDays = (duration === 'Half Day') ? 0.5 : diff;
                $('#leave_days').val(leaveDays);
            } else {
                $('#leave_days').val('');
            }
        }

        $('#from_date, #to_date, #leave_duration').on('change', calculateLeaveDays);
    });
</script>
@endsection
