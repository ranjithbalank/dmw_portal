@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        <span>Edit Leave Request</span>
                        <a href="{{ route('leaves.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('leaves.update', $leave->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            {{-- Employee Details --}}
                            <h6 class="text-muted border-bottom pb-1 mb-3">Employee Information</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Employee ID</label>
                                    <input type="text" class="form-control" value="{{ $leave->user_id }}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Name</label>
                                    <input type="text" class="form-control" value="{{ $leave->user->name }}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Role</label>
                                    <input type="text" class="form-control" value="{{ $leave->user->designation }}"
                                        disabled>
                                </div>
                            </div>

                            {{-- Leave Details --}}
                            <h6 class="text-muted border-bottom pb-1 mb-3">Leave Details</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_type" class="form-label fw-semibold">Leave Type</label>
                                    <select name="leave_type" id="leave_type" class="form-select" required>
                                        <option disabled>Select Type</option>
                                        <option value="casual" {{ $leave->leave_type == 'casual' ? 'selected' : '' }}>Casual
                                        </option>
                                        <option value="sick" {{ $leave->leave_type == 'sick' ? 'selected' : '' }}>Sick
                                        </option>
                                        <option value="earned" {{ $leave->leave_type == 'earned' ? 'selected' : '' }}>Earned
                                        </option>
                                        <option value="comp-off" {{ $leave->leave_type == 'comp-off' ? 'selected' : '' }}>
                                            Comp-Off</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="leave_duration" class="form-label fw-semibold">Duration</label>
                                    <select name="leave_duration" id="leave_duration" class="form-select" required>
                                        <option value="Full Day"
                                            {{ $leave->leave_duration == 'Full Day' ? 'selected' : '' }}>Full Day</option>
                                        <option value="Half Day"
                                            {{ $leave->leave_duration == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3" id="normal_date_fields">
                                <div class="col-md-6">
                                    <label for="from_date" class="form-label fw-semibold">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="{{ $leave->from_date }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="to_date" class="form-label fw-semibold">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ $leave->to_date }}">
                                </div>
                            </div>

                            <div class="row mb-3" id="comp_off_fields" style="display: none;">
                                <div class="col-md-6">
                                    <label for="comp_off_worked_date" class="form-label fw-semibold">Worked Date</label>
                                    <input type="date" name="comp_off_worked_date" id="comp_off_worked_date"
                                        class="form-control" value="{{ $leave->comp_off_worked_date }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="comp_off_leave_date" class="form-label fw-semibold">Leave Date</label>
                                    <input type="date" name="comp_off_leave_date" id="comp_off_leave_date"
                                        class="form-control" value="{{ $leave->comp_off_leave_date }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_days" class="form-label fw-semibold">No. of Leave Days</label>
                                    <input type="number" min="0" step="0.5" name="leave_days" id="leave_days"
                                        class="form-control" value="{{ $leave->leave_days }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Available Leaves</label>
                                    <input type="text" class="form-control bg-light fw-bold text-success"
                                        value="{{ $availableLeaves ?? 0 }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="reason" class="form-label fw-semibold">Reason</label>
                                    <textarea name="reason" id="reason" rows="3" class="form-control" required>{{ $leave->reason }}</textarea>
                                </div>
                            </div>

                            {{-- Status --}}

                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script>
        $(function() {
            function calculateLeaveDays() {
                const type = $('#leave_type').val();
                const duration = $('#leave_duration').val();
                if (type === 'comp-off') {
                    $('#leave_days').val(1);
                    return;
                }
                const from = new Date($('#from_date').val());
                const to = new Date($('#to_date').val());
                if (!isNaN(from) && !isNaN(to) && from <= to) {
                    const days = Math.floor((to - from) / (1000 * 60 * 60 * 24)) + 1;
                    $('#leave_days').val(duration === 'Half Day' ? 0.5 : days);
                } else {
                    $('#leave_days').val('');
                }
            }

            function toggleLeaveFields() {
                const type = $('#leave_type').val();
                if (type === 'comp-off') {
                    $('#comp_off_fields').show();
                    $('#normal_date_fields').hide();
                    $('#from_date, #to_date').prop('required', false);
                    $('#comp_off_worked_date, #comp_off_leave_date').prop('required', true);
                    $('#leave_duration option[value="Half Day"]').prop('disabled', true);
                    $('#leave_duration').val('Full Day').trigger('change');
                } else {
                    $('#comp_off_fields').hide();
                    $('#normal_date_fields').show();
                    $('#from_date, #to_date').prop('required', true);
                    $('#comp_off_worked_date, #comp_off_leave_date').prop('required', false);
                    $('#leave_duration option[value="Half Day"]').prop('disabled', false);
                }
            }

            $('#leave_type').on('change', () => {
                toggleLeaveFields();
                calculateLeaveDays();
            });
            $('#from_date, #to_date, #leave_duration').on('change', calculateLeaveDays);

            toggleLeaveFields();
            calculateLeaveDays();
        });
    </script>
@endsection
