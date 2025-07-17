<div class="offcanvas offcanvas-bottom" style="height:80%" tabindex="-1" id="offcanvasBottom{{ $job->id }}"
    aria-labelledby="offcanvasBottomLabel{{ $job->id }}">
    <div class="offcanvas-header border-bottom text-white align-center"
        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
        <h4 class="offcanvas-title fw-bold" id="offcanvasBottomLabel{{ $job->id }}">
            Job Details - {{ strtoupper($job->id) }} - {{ ucfirst($job->job_title) }}
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="container">

            {{-- ✅ Job details card --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <p><strong class="text-primary">Description:</strong>
                                {{ ucfirst($job->job_description) }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p><strong class="text-primary"> Unit / Division:</strong>
                                <span class="text-danger"><b><em>{{ ucfirst(strtolower($job->unit)) }} /
                                            {{ ucfirst(strtolower($job->division)) }}</em></b></span>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p><strong class="text-primary">Status:</strong>
                                @if ($job->status == 'active')
                                    <span class="badge text-bg-success">
                                        {{ ucfirst(strtolower($job->status)) }}
                                    </span>
                                @else
                                    <span class="badge text-bg-danger">
                                        {{ ucfirst(strtolower($job->status)) }}
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p><strong class="text-primary">Passing Date:</strong>
                                <span class="text-danger">
                                    <b><em>{{ \Carbon\Carbon::parse($job->passing_date)->format('d-m-Y') }}</em></b>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p><strong class="text-primary">End Date:</strong>
                                <span class="text-danger">
                                    <b><em>{{ \Carbon\Carbon::parse($job->end_date)->format('d-m-Y') }}</em></b>
                                </span>
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <p><strong class="text-primary">Slot Available:</strong>
                                {{ $job->slot_available }} slots</p>
                        </div>
                    </div>

                </div>
            </div>


            {{-- ✏️ Job Application Form --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Apply for this Job</h5>
                </div>
                <div class="card-body">
                    {{-- @if ($job->status == 'active')
                        <form action="{{ route('internal-jobs.apply', $job->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            <div hidden>{{ $job->id }} </div>
                            <div class="mb-3">
                                <label for="applicant_name_{{ $job->id }}" class="form-label">Applicant
                                    Name</label>
                                <input type="text" name="applicant_name" id="applicant_name_{{ $job->id }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="emp_qualifications{{ $job->id }}" class="form-label">Qualification
                                </label>
                                <input type="text" name="emp_qualifications"
                                    id="emp_qualifications{{ $job->id }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="emp_experience{{ $job->id }}" class="form-label">Experience </label>
                                <input type="text" name="emp_experience" id="emp_experience{{ $job->id }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="resume{{ $job->id }}" class="form-label">Upload Resume /
                                    Certificate</label>
                                <input type="file" name="emp_file" id="resume{{ $job->id }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Are you really Interested?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_interested"
                                        id="is_interested{{ $job->id }}" value="yes" required>
                                    <label class="form-check-label" for="is_interested{{ $job->id }}">Yes</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Submit Application</button>
                        </form>
                    @elseif($job->status != 'active')
                        <div class="alert alert-danger" role="alert">
                            Opps! This job is currently not active. You cannot apply.😒
                        </div>
                    @endif --}}
                    @if (in_array($job->id, $applications))
                        <div class="alert alert-warning" role="alert">
                            You have already applied for this job. ✅
                        </div>
                    @elseif ($job->status == 'active')
                        <form action="{{ route('internal-jobs.apply', $job->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Your form fields here -->
                            <div hidden>{{ $job->id }} </div>
                            <div class="mb-3">
                                <label for="applicant_name_{{ $job->id }}" class="form-label">Applicant
                                    Name</label>
                                <input type="text" name="applicant_name" class="form-control"
                                    value="{{ $user->name }}" readonly>

                            </div>
                            <div class="mb-3">
                                <label for="emp_qualifications{{ $job->id }}"
                                    class="form-label">Qualification</label>
                                <input type="text" name="emp_qualifications"
                                    id="emp_qualifications{{ $job->id }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="emp_experience{{ $job->id }}" class="form-label">Experience</label>
                                <input type="text" name="emp_experience" id="emp_experience{{ $job->id }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="resume{{ $job->id }}" class="form-label">Upload Resume /
                                    Certificate</label>
                                <input type="file" name="emp_file" id="resume{{ $job->id }}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Are you really Interested?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_interested"
                                        id="is_interested{{ $job->id }}" value="yes" required>
                                    <label class="form-check-label" for="is_interested{{ $job->id }}">Yes</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Submit Application</button>
                        </form>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Opps! This job is currently not active. You cannot apply. 😒
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
