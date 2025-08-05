<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\InternalJobPostings;
use App\Models\FinalJobStatus;
use App\Models\InternalJobApplications;

use App\Jobs\SendInternalJobEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\JobApplicantsExport;
use App\Imports\FinalStatusImport;
use App\Notifications\NewJobApplication;


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
        $results = FinalJobStatus::all();
        // Load applicants
        if ($user->hasAnyRole(['HR', 'Admin'])) {
            $applicants = InternalJobApplications::with(['user', 'job'])->get();
        } else {
            // 👇 Only load the current user's own applications
            $applicants = InternalJobApplications::with(['user', 'job'])
                ->where('employee_id', $user->id)
                ->get();
        }
        // dd($applicants);
        return view('internal_jobs.index', compact('jobs', 'applications', 'user', 'applicants','results'));
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

        $job = InternalJobPostings::create([
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

        $users = User::all();
        $jobs = [];

        // mail sending promt
        // foreach ($users as $user) {
        //     $jobs[] = new SendInternalJobEmail($user, $job);
        // }

        // Bus::batch($jobs)
        //     ->name('Notify users about IJP: ' . $job->job_title)
        //     ->dispatch();

        return redirect()->route('internal-jobs.index')
                        ->with('success', 'Job posting created successfully and email notifications sent.');
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
            'status' => 'required|string|in:active,inactive,closed',
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

    public function exportApplicantsPdf()
    {
        $applications = FinalJobStatus::with('job', 'user')->get();
        $pdf = Pdf::loadView('internal_jobs.export', compact('applications'))->setPaper('A4', 'landscape');
        return $pdf->download('internal_job_applicants.pdf');
    }


    public function exportApplicants(Request $request)
    {
        $jobId = $request->query('job_id');
        // dd($jobId);
        return Excel::download(new JobApplicantsExport($jobId), 'internal_job_applicants.xlsx');
    }


    public function uploadFinalStatus(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new FinalStatusImport, $request->file('excel_file'));
            return back()->with('success', 'Final Job Status imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


}
