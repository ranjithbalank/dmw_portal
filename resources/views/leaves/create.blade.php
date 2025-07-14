@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        <span>Apply for Leave</span>
                        <a href="{{ route('leaves.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    {{-- Show errors --}}
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

                    <form method="POST" action="{{ route('leaves.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Emp ID</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->id }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Emp Name</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Emp Role</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->designation }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                {{-- <div class="col-md-6">
                                    <label for="leave_type" class="form-label fw-bold">Leave Type</label>
                                    <select name="leave_type" id="leave_type" class="form-select" required>
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="casual">Casual</option>
                                        <option value="sick">Sick</option>
                                        <option value="earned">Earned</option>
                                        <option value="comp-off">Comp-Off</option>
                                        {{-- <option value="od">On-Duty</option> --}}
                                        {{-- <option value="permission">Permission</option> --}}
                                    {{-- </select> --}}
                                {{-- </div> --}}

                                {{-- <div class="col-md-6">
                                    <label for="leave_duration" class="form-label fw-bold">Duration</label>
                                    <select name="leave_duration" id="leave_duration" class="form-select" required>
                                        <option value="" disabled selected>-- Select Duration --</option>
                                        <option value="Full Day">Full Day</option>
                                        <option value="Half Day">Half Day</option>
                                    </select>
                                </div> --}}
                            </div>

                            <div class="row mb-3" id="normal_date_fields">
                                <div class="col-md-6">
                                    <label for="from_date" class="form-label fw-bold">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        min="{{ $minDate }}" value="{{ old('from_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="to_date" class="form-label fw-bold">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        min="{{ $minDate }}" value="{{ old('to_date') }}">
                                </div>
                            </div>

                            <div class="row mb-3" id="comp_off_fields" style="display: none;">
                                <div class="col-md-6">
                                    <label for="comp_off_worked_date" class="form-label fw-bold">Worked Date</label>
                                    <input type="date" name="comp_off_worked_date" id="comp_off_worked_date"
                                        class="form-control" min="{{ $minDate }}"
                                        value="{{ old('comp_off_worked_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="comp_off_leave_date" class="form-label fw-bold">Leave Date</label>
                                    <input type="date" name="comp_off_leave_date" id="comp_off_leave_date"
                                        class="form-control" min="{{ $minDate }}"
                                        value="{{ old('comp_off_leave_date') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leave_days" class="form-label fw-bold">No. of Leave Days</label>
                                    <input type="number" min="0" step="0.5" name="leave_days" id="leave_days"
                                        class="form-control" value="{{ old('leave_days') }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Available Leaves</label>
                                    <input type="text" class="form-control bg-light fw-bold text-success"
                                        value="{{ $availableLeaves ?? 0 }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="reason" class="form-label fw-bold">Reason</label>
                                    <textarea name="reason" id="reason" rows="3" class="form-control" required>{{ old('reason') }}</textarea>
                                </div>
                            </div>
                        </div>

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

            function setMinDates() {
                const today = new Date();
                today.setDate(today.getDate() - 7); // add 7 days
                const minDate = today.toISOString().split('T')[0];


                $('#from_date').attr('min', minDate);
                $('#to_date').attr('min', minDate);
                $('#comp_off_leave_date').attr('min', minDate);
            }

            $('#leave_type').on('change', () => {
                toggleLeaveFields();
                calculateLeaveDays();
            });
            $('#from_date, #to_date, #leave_duration').on('change', calculateLeaveDays);

            toggleLeaveFields();
            calculateLeaveDays();
            setMinDates();
        });
    </script>
@endsection
