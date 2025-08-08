<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignUnitPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $units = Unit::all();
        $permissions = permission::all();
        $modules = Module::all();

        // Fetch from custom pivot table
        $roleUnitPermissions = DB::table('role_unit_permissions')->get();

        return view('assign_unit_permission.index', compact(
            'roles', 'units', 'permissions', 'roleUnitPermissions',"modules"
        ));
    }
    public function fetch(Request $request)
    {
        $data = DB::table('role_unit_permissions') // ✅ corrected table name
            ->where('unit_id', $request->unit_id)
            ->where('role_id', $request->role_id)
            ->pluck('permission');

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $units = unit::all();
        $permissions = Permission::all();
        $modules = Module::all();

        return view('assign_unit_permission.create', compact('roles', 'units','permissions', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'unit_id' => 'required|exists:units,id',
            'module_id' => 'required|exists:modules,id',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        foreach ($validated['permission_ids'] as $permissionId) {
            DB::table('role_unit_permissions')->updateOrInsert([
                'role_id' => $validated['role_id'],
                'unit_id' => $validated['unit_id'],
                'module_id' => $validated['module_id'],
                'permission_id' => $permissionId,
            ], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Permissions assigned successfully.');
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
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $units = Unit::all();
        $permissions = Permission::all();

        // Fetch existing permissions assigned to this role
        $existingPermissions = DB::table('role_unit_permissions')->where('role_id', $role->id)->get();

        return view('assign_unit_permission.edit', compact(
            'role',
            'units',
            'permissions',
            'existingPermissions'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Delete old permissions
        DB::table('role_unit_permissions')->where('role_id', $id)->delete();

        // Insert new permissions
        foreach ($request->input('permissions', []) as $unitId => $perms) {
            foreach ($perms as $permName => $value) {
                DB::table('role_unit_permissions')->insert([
                    'role_id' => $id,
                    'unit_id' => $unitId,
                    'permission' => $permName,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }

        // Return a response or redirect
        return redirect()->back()->with('success', 'Permissions updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
