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
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="applicant_name_{{ $job->id }}" class="form-label">Your Name</label>
                            <input type="text" name="applicant_name" id="applicant_name_{{ $job->id }}"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="applicant_email_{{ $job->id }}" class="form-label">Your Email</label>
                            <input type="email" name="applicant_email" id="applicant_email_{{ $job->id }}"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="applicant_resume_{{ $job->id }}" class="form-label">Resume (brief)</label>
                            <textarea name="applicant_resume" id="applicant_resume_{{ $job->id }}" class="form-control" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit Application</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
