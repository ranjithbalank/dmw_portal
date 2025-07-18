<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InternalJobApplications;
use App\Notifications\NewJobApplication;
use App\Models\InternalJobPostings; // ✅ correct import

class InternalJobPostingController extends Controller // ✅ correct class name
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = InternalJobPostings::all();
        $applications = InternalJobApplications::where('employee_id', Auth::id())->pluck('job_id')->toArray();
        $user = Auth::user();

        // Load applicants only if user has HR/Admin role
        $applicants = [];
        if ($user->hasAnyRole(['HR', 'Admin'])) {
            $applicants = InternalJobApplications::with(['user', 'job'])->get();
        }

        return view('internal_jobs.index', compact('jobs', 'applications', 'user', 'applicants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobId = InternalJobPostings::max('id') + 1;

        return view('internal_jobs.create',compact('jobId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'slot_available'  => 'required|integer|min:1',
            'qualification' => 'required|string|max:255',
            'work_experience' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'passing_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:passing_date',
            'status' => 'required|string|in:active,inactive',
        ]);

        InternalJobPostings::create([
            'job_title' => $request->job_title,
            'job_description' => $request->job_description,
            'qualifications' => $request->qualification,
            'work_experience' => $request->work_experience,
            'slot_available' => $request->slot_available,
            'unit' => $request->unit,
            'division' => $request->division,
            'passing_date' => $request->passing_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('internal-jobs.index')
                         ->with('success', 'Job posting created successfully!');
    }

    public function show(string $id)
    {
        $jobs = InternalJobPostings::find($id);
        $applications = InternalJobApplications::where('employee_id', Auth::id())->pluck('job_id')->toArray();
        return view('internal_jobs.show',compact('jobs', 'applications'));
    }

    public function edit(string $id)
    {
        $jobs = InternalJobPostings::find($id);
        return view('internal_jobs.edit',compact('jobs'));
        //
    }

   public function update(Request $request, $id)
    {
        // Validate data
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'slot_available'  => 'required|integer|min:1',
            'qualification' => 'required|string|max:255',
            'work_experience' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'passing_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:passing_date',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Find the job by ID
        $job = InternalJobpostings::findOrFail($id);

        // Update the job
        $job->update($validated);

        // Redirect or return response
        return redirect()->route('internal-jobs.index')
                        ->with('success', 'Job updated successfully!');
    }


   public function destroy(InternalJobpostings $internal_job)
    {
        $internal_job->delete();

        return redirect()->route('internal-jobs.index')
                        ->with('success', 'Job deleted successfully!');
    }

    public function apply(Request $request, $job)
    {
        // Check if user already applied BEFORE validating the file
        $existing = InternalJobApplications::where('employee_id', Auth::id())
            ->where('job_id', $job)
            ->first();

        if ($existing) {
            return redirect()->route('internal-jobs.index')
                ->with('error', 'You have already applied for this position!');
        }

        // Validate input
        $request->validate([
            'emp_qualifications' => 'required|string|max:255',
            'emp_experience' => 'required|string|max:255',
            'emp_file' => 'required|file|mimes:pdf',
            'is_interested' => 'required',
        ]);

        // Check file size warning
        $file = $request->file('emp_file');
        $sizeInMB = $file->getSize() / 1024 / 1024;

        if ($sizeInMB > 2) {
            session()->flash('warning', 'Your uploaded file is large (over 2MB). Uploading may take longer.');
        }

        // Store file
        $path = $file->store('resumes', 'public');

        InternalJobApplications::create([
            'employee_id' => Auth::id(),
            'job_id' => $job,
            'emp_qualifications' => $request->emp_qualifications,
            'emp_experience' => $request->emp_experience,
            'resume_path' => $path,
        ]);

        return redirect()->route('internal-jobs.index')
            ->with('success', 'You have successfully applied for the position! HR will reach out soon!');
    }


}
