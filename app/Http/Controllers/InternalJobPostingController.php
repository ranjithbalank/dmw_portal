<?php

namespace App\Http\Controllers;

use App\Models\InternalJobPostings; // ✅ correct import
use Illuminate\Http\Request;

class InternalJobPostingController extends Controller // ✅ correct class name
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = InternalJobPostings::all();

        return view('internal_jobs.index', compact('jobs'));
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
        return view('internal_jobs.show');
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

}
