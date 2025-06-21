<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $roles = Role::all();
        $permission = Permission::all();

        return view('roles.index', compact('roles', 'permission'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'status' => 'required|in:active,inactive',
            'guardname' => 'required|string',
            'permission_id' => 'required|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'status' => $request->status,
            'guard_name' => $request->guardname,
        ]);

        // Get Permission models by IDs and guard_name
        $permissions = Permission::whereIn('id', $request->permission_id)
            ->where('guard_name', $request->guardname)
            ->get();

        // Sync permissions using models (not just IDs)
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);

        return response()->json([
            'name' => $role->name,
            'guard_name' => $role->guard_name,
            'status' => $role->status,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    /**
     * Update the specified resource in storage.
     */




    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
            'guardname' => 'required|string',
            'permission_id' => 'required|array',
        ]);

        $role = Role::findOrFail($id);

        // Update role fields except name (if you want to allow name change, add validation and update)
        $role->status = $request->status;
        $role->guard_name = $request->guardname;
        $role->save();

        // Fetch permissions with matching IDs and guard
        $permissions = Permission::whereIn('id', $request->permission_id)
            ->where('guard_name', $request->guardname)
            ->get();

        // Sync permissions with role
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // not REQUIRED as we are inactivating this 
    }
}
