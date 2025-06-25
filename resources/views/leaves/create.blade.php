@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        <span>{{ 'Apply for Leave' }}</span>
                        <a href="{{ route('leaves.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    {{-- ✅ Form wraps both card-body and card-footer --}}
                    <form method="POST" action="{{ route('leaves.store') }}">
                        @csrf

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Emp ID</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->id }}" disabled>
                                    <input type="hidden" name="employee_id" value="{{ auth()->user()->id }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Emp Name</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Emp Role</label>
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->getRoleNames()->first() }}" disabled>
                                </div>
                            </div>

                            {{-- Leave Type & Duration --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_type" class="form-label fw-bold">Leave Type</label>
                                    <select name="leave_type" id="leave_type" class="form-select select2" required>
                                        <option value="" disabled selected>Select Type </option>
                                        <option value="casual">Casual</option>
                                        <option value="sick">Sick</option>
                                        <option value="earned">Earned</option>
                                        <option value="comp-off">Comp-Off</option>
                                        <option value="od">On-Duty</option>
                                        <option value="permission">Permission</option>
                                    </select>
                                    @error('leave_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="leave_duration" class="form-label fw-bold">Duration</label>
                                    <select name="leave_duration" id="leave_duration" class="form-select select2" required>
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

                            {{-- Comp-Off Specific Fields --}}
                            <div id="comp_off_fields" style="display: none;">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="comp_off_worked_date" class="form-label fw-bold">Worked Date (Earned
                                            Comp-Off)</label>
                                        <input type="date" name="comp_off_worked_date" id="comp_off_worked_date"
                                            class="form-control" value="{{ old('comp_off_worked_date') }}">
                                        @error('comp_off_worked_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="comp_off_leave_date" class="form-label fw-bold">Leave Date (Using
                                            Comp-Off)</label>
                                        <input type="date" name="comp_off_leave_date" id="comp_off_leave_date"
                                            class="form-control" value="{{ old('comp_off_leave_date') }}">
                                        @error('comp_off_leave_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Leave Days & Available --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_days" class="form-label fw-bold">No. of Leave Days</label>
                                    <input type="number" min="0" step="0.5" name="leave_days"
                                        id="leave_days" class="form-control" value="{{ old('leave_days') }}" readonly
                                        required>
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
                        </div> {{-- End card-body --}}

                        {{-- Submit in Card Footer --}}
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function calculateLeaveDays() {
                const leaveType = $('#leave_type').val();
                const duration = $('#leave_duration').val();

                if (leaveType === 'comp-off') {
                    $('#leave_days').val(1);
                    return;
                }

                const fromDate = new Date($('#from_date').val());
                const toDate = new Date($('#to_date').val());

                if (!isNaN(fromDate) && !isNaN(toDate) && fromDate <= toDate) {
                    let diff = Math.floor((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;
                    let leaveDays = (duration === 'Half Day') ? 0.5 : diff;
                    $('#leave_days').val(leaveDays);
                } else {
                    $('#leave_days').val('');
                }
            }

            function toggleFieldsForLeaveType() {
                const leaveType = $('#leave_type').val();

                if (leaveType === 'comp-off') {
                    $('#comp_off_fields').show();
                    $('#from_date').closest('.col-md-6').parent().hide();
                    $('#to_date').closest('.col-md-6').parent().hide();
                    $('#leave_duration option[value="Half Day"]').prop('disabled', true);
                    $('#leave_duration').val('Full Day').trigger('change');
                    $('#leave_days').val(1);
                } else {
                    $('#comp_off_fields').hide();
                    $('#from_date').closest('.col-md-6').parent().show();
                    $('#to_date').closest('.col-md-6').parent().show();
                    $('#leave_duration option[value="Half Day"]').prop('disabled', false);
                }
            }

            $('#leave_type').on('change', function() {
                toggleFieldsForLeaveType();
                calculateLeaveDays();
            });

            $('#from_date, #to_date, #leave_duration').on('change', calculateLeaveDays);

            // Initial
            toggleFieldsForLeaveType();
            calculateLeaveDays();
        });
    </script>
@endsection
