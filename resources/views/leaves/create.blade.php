@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        <span>{{ __('Apply for Leave') }}</span>
                        <a href="{{ route('leaves.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('leaves.store') }}">
                            @csrf
                            
                            {{-- Leave Type & Duration --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_type" class="form-label fw-bold">Leave Type</label>
                                    <select name="leave_type" id="leave_type" class="form-select" required>
                                        <option value="" disabled selected>-- Select Type --</option>
                                        <option value="casual">Casual</option>
                                        <option value="sick">Sick</option>
                                        <option value="earned">Earned</option>
                                    </select>
                                    @error('leave_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="leave_duration" class="form-label fw-bold">Duration</label>
                                    <select name="leave_duration" id="leave_duration" class="form-select" required>
                                        <option value="" disabled selected>-- Select Duration --</option>
                                        <option value="Full Day">Full Day</option>
                                        <option value="Half Day">Half Day</option>
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
                                        value="{{ old('from_date') }}" required>
                                    @error('from_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="to_date" class="form-label fw-bold">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ old('to_date') }}" required>
                                    @error('to_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Leave Days & Available --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_days" class="form-label fw-bold">No. of Leave Days</label>
                                    <input type="number" min="0" step="0.5" name="leave_days" id="leave_days"
                                        class="form-control" value="{{ old('leave_days') }}" readonly required>
                                    @error('leave_days')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Available Leaves</label>
                                    <input type="text" class="form-control bg-light fw-bold text-success"
                                        value="{{ $availableLeaves ?? 0 }}" readonly>
                                </div>
                            </div>

                            {{-- Reason --}}
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="reason" class="form-label fw-bold">Reason</label>
                                    <textarea name="reason" id="reason" rows="3" class="form-control" required>{{ old('reason') }}</textarea>
                                    @error('reason')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
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
