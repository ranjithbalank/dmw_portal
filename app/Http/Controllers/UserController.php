<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        $user_details = UserDetails::all();
        return view("users.index", [
            "users" => $users,
            "user_details" => $user_details
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        // $ipAddress = $request->ip();

        return view("users.create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string',
            'roles'    => 'required|array', // ← multiple role IDs
            'division' => 'required|string',
            'divcode'  => 'required|string',
            'status'   => 'required|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign multiple roles


        // Save user_details
        $user->details()->create([
            'role'     => implode(',', $request->roles), // or store one primary role if needed
            'division' => $request->division,
            'divcode'  => $request->divcode,
            'status'   => $request->status,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('details')->findOrFail($id);

        return view('users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('details')->findOrFail($id);
        $roles = Role::all();
        // dd($user);
        return view("users.edit", [
            "user" => $user,
            "roles" => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:6',
            'roles'    => 'required|array|size:1',
            'status'   => 'required|string|in:active,inactive',
            'division' => 'nullable|string|max:255',
            'divcode'  => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        $user->syncRoles($request->roles);

        $user->details()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'role'     => $request->roles[0],
                'status'   => $request->status,
                'division' => $request->division,
                'divcode'  => $request->divcode,
            ]
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->details) {
            $user->details->delete();
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User Deleted successfully.');
    }
}
