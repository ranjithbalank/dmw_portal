<?php

namespace App\Http\Controllers;

use App\Models\Circular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CircularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $circulars = Circular::orderBy('circular_date', 'desc')->get();

        return view('circular.index', compact('circulars'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('circular.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $request->validate([
            'circular_number' => 'required|string|max:255',
            'circular_date' => 'required|date',
            'circular_file' => 'required|file|mimes:pdf|max:5120', // max 5MB
        ]);

        // Check if a file is uploaded
        if ($request->hasFile('circular_file')) {
            // Store the uploaded file in the public storage
            $path = $request->file('circular_file')->store('circulars', 'public');
        } else {
            return back()->with('error', 'No file was uploaded.');
        }

        // Create a new Circular entry
        Circular::create([
            'circular_no' => $request->circular_number,
            'circular_date' => $request->circular_date,
            'created_by' => Auth::user()->name,
            'file_path' => $path,
        ]);

        return redirect()->route('circulars.index')->with('success', 'Circular uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Circular $Circular)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Circular $Circular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Circular $Circular)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Circular $Circular)
    {
        //
    }
}
