@extends('layouts.app')

@section('title', 'Internal Job Posting')

{{-- DataTables CSS --}}
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        Internal Job Posting
                        <a href="{{ route('home') }}" class="btn btn-sm btn-light text-dark">← Back</a>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger m-3 alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs mb-3" id="jobTabs" role="tablist">
                            <li class="nav-item">

                                <button class="nav-link active" id="jobs-tab" data-bs-toggle="tab"
                                    data-bs-target="#jobs-tab-pane" type="button" role="tab">
                                    Job Listings
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="results-tab" data-bs-toggle="tab"
                                    data-bs-target="#myhistory-tab-pane" type="button" role="tab">
                                    My Application
                                </button>
                            </li>
                            @hasanyrole(['HR', 'Admin'])
                                <li class="nav-item">
                                    <button class="nav-link" id="applicants-tab" data-bs-toggle="tab"
                                        data-bs-target="#applicants-tab-pane" type="button" role="tab">
                                        Job Applicants
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="results-tab" data-bs-toggle="tab"
                                        data-bs-target="#results-tab-pane" type="button" role="tab">
                                        Final Job Status
                                    </button>
                                </li>
                            @endhasanyrole
                        </ul>

                        <div class="tab-content">
                            {{-- Job Listings --}}
                            <div class="tab-pane fade show active" id="jobs-tab-pane">
                                <div class="d-flex justify-content-end mb-3">
                                    @hasanyrole(['HR', 'Admin'])
                                        <a href="{{ route('internal-jobs.create') }}" class="btn btn-success btn-sm shadow-sm">
                                            <i class="bi bi-plus-circle"></i> Create New Job
                                        </a>
                                    @endhasanyrole
                                </div>

                                <div class="table-responsive">
                                    <table id="ticketsTable" class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S.No</th>
                                                <th>IJP ID</th>
                                                <th>Role</th>
                                                <th>Qualification</th>
                                                <th>Experience</th>
                                                <th>Unit</th>
                                                <th>Slots</th>
                                                <th>Last Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $count = 1; @endphp
                                            @foreach ($jobs as $job)
                                                @if ($job->status === 'active' || Auth::user()->hasAnyRole(['HR', 'Admin']))
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>IJP - {{ $job->id }}</td>
                                                        <td>{{ ucfirst($job->job_title) }}</td>
                                                        <td>{{ $job->qualifications }}</td>
                                                        <td class="text-center">{{ $job->work_experience }}</td>
                                                        <td>{{ $job->unit }}</td>
                                                        <td>{{ $job->slot_available }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($job->end_date)->format('d-m-Y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span
                                                                class="btn btn-sm {{ $job->status === 'active' ? 'btn-success' : 'btn-secondary' }}">
                                                                {{ ucfirst($job->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-info" data-bs-toggle="offcanvas"
                                                                data-bs-target="#offcanvasBottom{{ $job->id }}">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            @hasanyrole(['Admin|HR'])
                                                                <a href="{{ route('internal-jobs.edit', $job->id) }}"
                                                                    class="btn btn-sm btn-warning">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                            @endhasanyrole
                                                        </td>
                                                    </tr>
                                                    @include('internal_jobs.show', ['job' => $job])
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="myhistory-tab-pane">
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="d-flex justify-content-end">
                                        <form method="GET" action="{{ route('export.applicants') }}">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    ⬇️ Export
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="bi bi-file-earmark-excel"></i> Download as Excel
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="submit"
                                                            formaction="{{ route('export.applicants.pdf') }}"
                                                            class="dropdown-item text-danger">
                                                            <i class="bi bi-file-earmark-pdf"></i> Download as PDF
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table id="myappTable"
                                        class="table table-bordered table-light align-middle text-center w-100">

                                        <thead class="table-light align-middle text-center">
                                            <tr>
                                                <th style="width: 50px;">S.No</th>
                                                <th style="width: 100px;">IJP ID</th>
                                                <th style="width: 200px;">Job Title</th>
                                                {{-- <th style="width: 180px;">Applicant</th> --}}
                                                <th style="width: 220px;">Email</th>
                                                <th style="width: 220px;">Status</th>
                                                <th style="width: 120px;">Resume</th>
                                            </tr>
                                            {{-- <tr class="bg-light">
                                                    <th></th>
                                                    <th>
                                                        <input type="text" placeholder="Search ID"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th>
                                                        <input type="text" placeholder="Search Title"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th>
                                                        <input type="text" placeholder="Search Name"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th>
                                                        <input type="text" placeholder="Search Email"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th></th>
                                                </tr> --}}
                                        </thead>
                                        <tbody>
                                            @php $counter = 1; @endphp
                                            {{-- @dd($applicants); --}}
                                            @foreach ($applicants as $applicant)
                                                @if ($applicant->employee_id === auth()->id())
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>IJP - {{ $applicant->job->id ?? '-' }}</td>
                                                        <td class="text-primary fw-bold">
                                                            {{ ucfirst($applicant->job->job_title ?? '-') }}</td>
                                                        {{-- <td>{{ $applicant->user->name ?? '-' }}</td> --}}
                                                        <td>{{ $applicant->user->email ?? '-' }}</td>
                                                        <td>
                                                            @if ($applicant->status == 'applied')
                                                                <span class="text-white btn btn-primary">Applied</span>
                                                            @elseif($applicant->status == 'selected' || $applicant->status == 'Selected')
                                                                <span class="text-white btn btn-success">Selected</span>
                                                            @elseif($applicant->status == 'rejected' || $applicant->status == 'Rejected')
                                                                <span class="text-white btn btn-danger ">Rejected</span>
                                                            @endif
                                                        <td>
                                                            @if ($applicant->resume_path)
                                                                <button class="btn btn-sm btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#resumeModal{{ $applicant->id }}">
                                                                    <i class="bi bi-file-earmark-text"></i>
                                                                </button>

                                                                <div class="modal fade"
                                                                    id="resumeModal{{ $applicant->id }}" tabindex="-1"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-xl modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header text-white"
                                                                                style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                                                                                <h5 class="modal-title">
                                                                                    Resume –
                                                                                    {{ $applicant->user->name ?? '' }}
                                                                                    - For the
                                                                                    {{ $applicant->job->job_title ?? '' }}
                                                                                    position
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"></button>
                                                                            </div>
                                                                            <div class="modal-body p-0">
                                                                                <iframe
                                                                                    src="{{ asset('storage/' . $applicant->resume_path) }}"
                                                                                    width="100%" height="600px"
                                                                                    style="border: none;"></iframe>
                                                                            </div>
                                                                            <div
                                                                                class="modal-footer d-flex justify-content-end">
                                                                                <a href="{{ asset('storage/' . $applicant->resume_path) }}"
                                                                                    class="btn btn-success" download>
                                                                                    <i class="bi bi-download"></i> Download
                                                                                    Resume
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">No Resume</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Job Applicants --}}
                            @hasanyrole(['HR', 'Admin'])
                                <div class="tab-pane fade" id="applicants-tab-pane">
                                    <div class="d-flex justify-content-end mb-3">
                                        <div class="d-flex justify-content-end">
                                            <form method="GET" action="{{ route('export.applicants') }}">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        ⬇️ Export
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="bi bi-file-earmark-excel"></i> Download as Excel
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="submit"
                                                                formaction="{{ route('export.applicants.pdf') }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="bi bi-file-earmark-pdf"></i> Download as PDF
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>

                                    </div>


                                    <div class="table-responsive">
                                        <table id="applicantsTable"
                                            class="table table-bordered table-light align-middle text-center w-100">

                                            <thead class="table-light align-middle text-center">
                                                <tr>
                                                    <th style="width: 50px;">S.No</th>
                                                    <th style="width: 100px;">IJP ID</th>
                                                    <th style="width: 200px;">Job Title</th>
                                                    <th style="width: 180px;">Applicant</th>
                                                    <th style="width: 220px;">Email</th>
                                                    <th style="width: 120px;">Resume</th>
                                                </tr>
                                                {{-- <tr class="bg-light">
                                                    <th></th>
                                                    <th>
                                                        <input type="text" placeholder="Search ID"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th>
                                                        <input type="text" placeholder="Search Title"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th>
                                                        <input type="text" placeholder="Search Name"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th>
                                                        <input type="text" placeholder="Search Email"
                                                            class="form-control form-control-sm w-100"
                                                            style="font-size: 13px;" />
                                                    </th>
                                                    <th></th>
                                                </tr> --}}
                                            </thead>


                                            <tbody>
                                                @php $counter = 1; @endphp
                                                @foreach ($applicants as $applicant)
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>IJP - {{ $applicant->job->id ?? '-' }}</td>
                                                        <td>{{ ucfirst($applicant->job->job_title ?? '-') }}</td>
                                                        <td>{{ $applicant->user->name ?? '-' }}</td>
                                                        <td>{{ $applicant->user->email ?? '-' }}</td>
                                                        <td>
                                                            @if ($applicant->resume_path)
                                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                    data-bs-target="#resumeModal{{ $applicant->id }}">
                                                                    <i class="bi bi-file-earmark-text"></i>
                                                                </button>

                                                                <div class="modal fade" id="resumeModal{{ $applicant->id }}"
                                                                    tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header text-white"
                                                                                style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                                                                                <h5 class="modal-title">
                                                                                    Resume – {{ $applicant->user->name ?? '' }}
                                                                                    - For the
                                                                                    {{ $applicant->job->job_title ?? '' }}
                                                                                    position
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"></button>
                                                                            </div>
                                                                            <div class="modal-body p-0">
                                                                                <iframe
                                                                                    src="{{ asset('storage/' . $applicant->resume_path) }}"
                                                                                    width="100%" height="600px"
                                                                                    style="border: none;"></iframe>
                                                                            </div>
                                                                            <div
                                                                                class="modal-footer d-flex justify-content-end">
                                                                                <a href="{{ asset('storage/' . $applicant->resume_path) }}"
                                                                                    class="btn btn-success" download>
                                                                                    <i class="bi bi-download"></i> Download
                                                                                    Resume
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">No Resume</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- Final Job Status Results Tab --}}
                                <div class="tab-pane fade" id="results-tab-pane">
                                    <div class="table-responsive">
                                        <form action="{{ route('import.applicants.pdf') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex justify-content-end">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <label for="excel_file" class="form-label text-danger mb-0">
                                                        <strong>Upload Job Results (Excel):</strong>
                                                    </label>

                                                    <input type="file" name="excel_file"
                                                        class="form-control form-control-sm" style="max-width: 220px;"
                                                        required>

                                                    <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <br>
                                    <table id="finalTable" class="table table-bordered table-hover align-middle text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>IJP ID</th>
                                                <th>Job Title</th>
                                                <th>Applicant</th>
                                                <th>Email</th>

                                                <th>Qualifications</th>
                                                <th>Experience</th>
                                                <th>Interview Panel</th>
                                                <th>Status</th>
                                                {{-- <th>Result</th> --}}
                                                <th>Joining Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $count = 1; @endphp
                                            @foreach ($results as $result)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>IJP - {{ $result->ijp_id }}</td>
                                                    <td>{{ ucfirst($result->job_title) }}</td>
                                                    <td>{{ $result->applicant }}</td>
                                                    <td>{{ $result->email }}</td>
                                                    <td>{{ $result->qualifications }}</td>
                                                    <td>{{ $result->experience }}</td>
                                                    <td>{{ ucfirst($result->interview_panel) }}</td>
                                                    <td>
                                                        @if ($applicant->status == 'applied')
                                                            <span class="text-white btn btn-primary">Applied</span>
                                                        @elseif($applicant->status == 'selected' || $applicant->status == 'Selected')
                                                            <span class="text-white btn btn-success">Selected</span>
                                                        @elseif($applicant->status == 'rejected' || $applicant->status == 'Rejected')
                                                            <span class="text-white btn btn-danger ">Rejected</span>
                                                        @endif
                                                    </td>
                                                        {{-- <td>{{ $result->interview_result }}</td> --}}
                                                    <td>{{ \Carbon\Carbon::parse($result->joining_date)->format('d-m-Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endhasanyrole
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            const jobsTable = $('#ticketsTable').DataTable({
                responsive: true
            });
            const applicantsTable = $('#applicantsTable').DataTable({
                responsive: true
            });
            const myappTable = $('#myappTable').DataTable({
                responsive: true
            });
            const resultTable = $('#resultTable').DataTable({
                responsive: true
            });
            const finalTable = $('#finalTable').DataTable({
                responsive: true
            });

            // Add column-specific search for applicants
            $('#applicantsTable thead tr:eq(1) th').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (applicantsTable.column(i).search() !== this.value) {
                        applicantsTable.column(i).search(this.value).draw();
                    }
                });
            });
        });
    </script>
@endsection
