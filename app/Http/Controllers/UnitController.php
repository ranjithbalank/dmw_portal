<?php

namespace App\Http\Controllers;

use App\Models\unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('units.index', [
            'units' => unit::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Step 1: Validate Input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'code' => 'required|string|max:50|unique:units,code',
            'status' => 'required|in:active,inactive',
            'permission_id' => 'array',
            'permission_id.*' => 'exists:permissions,id',
        ]);

        // Step 2: Create the Unit
        $unit = new unit();
        $unit->name = $validated['name'];
        $unit->code = $validated['code'];
        $unit->status = $validated['status'];
        $unit->save();

        // Step 3: Assign Permissions (if relationship exists)
        if ($request->has('permission_id')) {
            $unit->permissions()->sync($request->permission_id); // Ensure relationship exists
        }

        return redirect()->route('unit.index')
            ->with('success', 'Unit created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
