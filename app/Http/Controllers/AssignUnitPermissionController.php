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
        // Get all necessary data
        $roles = Role::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $modules = Module::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        // Fetch assignments with eager loaded relationships
        $assignments = DB::table('role_unit_permissions')
            ->select([
                'role_unit_permissions.id',
                'role_unit_permissions.role_id',
                'role_unit_permissions.unit_id',
                'role_unit_permissions.module_id',
                'role_unit_permissions.permission_id',
                'roles.name as role_name',
                'units.name as unit_name',
                'units.code as unit_code',
                'modules.name as module_name',
                'permissions.name as permission_name'
            ])
            ->join('roles', 'role_unit_permissions.role_id', '=', 'roles.id')
            ->join('units', 'role_unit_permissions.unit_id', '=', 'units.id')
            ->join('modules', 'role_unit_permissions.module_id', '=', 'modules.id')
            ->join('permissions', 'role_unit_permissions.permission_id', '=', 'permissions.id')
            ->orderBy('roles.name')
            ->orderBy('units.name')
            ->orderBy('modules.name')
            ->get();

        // Group assignments by role-unit-module combination for display
        $groupedAssignments = $assignments->groupBy(function ($item) {
            return $item->role_id.'-'.$item->unit_id.'-'.$item->module_id;
        });

        return view('assign_unit_permission.index', compact(
            'roles',
            'units',
            'modules',
            'permissions',
            'groupedAssignments'
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
        // dd($request->all());
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
        // Get the assignment with joins to make sure all IDs exist
        $assignment = DB::table('role_unit_permissions')
            ->select('role_unit_permissions.*')
            ->where('role_unit_permissions.id', $id)
            ->first();

        if (!$assignment) {
            abort(404, 'Assignment not found');
        }

        // Fetch all dropdown data
        $roles = Role::orderBy('name')->get(); // Fixed the typo from 'a' to proper query
        $units = Unit::orderBy('name')->get();
        $modules = Module::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        // Get assigned permissions for this role-unit-module
        $assignedPermissions = DB::table('role_unit_permissions')
            ->where('role_id', $assignment->role_id)
            ->where('unit_id', $assignment->unit_id)
            ->where('module_id', $assignment->module_id)
            ->pluck('permission_id')
            ->toArray();

        return view('assign_unit_permission.edit', compact(
            'assignment',
            'roles',
            'units',
            'modules',
            'permissions',
            'assignedPermissions'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'role_id' => 'required|exists:roles,id',
        'unit_id' => 'required|exists:units,id',
        'module_id' => 'required|exists:modules,id',
        'permission_ids' => 'nullable|array',
        'permission_ids.*' => 'exists:permissions,id',
    ]);

    // Ensure permission_ids is an array, even if empty
    $permissionIds = $validated['permission_ids'] ?? [];

    // Delete existing permissions for this role-unit-module
    DB::table('role_unit_permissions')
        ->where('role_id', $validated['role_id'])
        ->where('unit_id', $validated['unit_id'])
        ->where('module_id', $validated['module_id'])
        ->delete();

    // Insert new permissions if any
    foreach ($permissionIds as $permissionId) {
        DB::table('role_unit_permissions')->insert([
            'role_id' => $validated['role_id'],
            'unit_id' => $validated['unit_id'],
            'module_id' => $validated['module_id'],
            'permission_id' => $permissionId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('assign-unit-permissions.index')->with('success', 'Permissions updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
