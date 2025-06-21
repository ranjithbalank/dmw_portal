<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $permissions = Permission::all(); // or some other query
        
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view("permissions.create", compact("permissions"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'status' => $request->status,
            'guard_name' => $request->guardname, // Required field
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */


    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);

        return response()->json([
            'name' => $permission->name,
            'guard_name' => $permission->guard_name,
            'created_at' => Carbon::parse($permission->created_at)->format('d-M-Y h:i A'),
            'updated_at' => Carbon::parse($permission->updated_at)->format('d-M-Y h:i A'),
        ]);
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
