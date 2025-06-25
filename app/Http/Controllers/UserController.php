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

        // $user_details = UserDetails::all();
        return view("users.index", [
            "users" => $users,
            // "user_details" => $user_details
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $user = User::all();
        // $ipAddress = $request->ip();

        return view("users.create", compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'employee_id'   => ['required', 'string', 'max:20', 'unique:users'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'unit'          => ['required', 'string', 'max:100'],
            'department'    => ['required', 'string', 'max:100'],
            'manager_id'    => ['required', 'string', 'max:255'],
            'designation'   => ['required', 'string', 'max:100'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'roles'         => ['required', 'array'],
        ]);

        // Create user
        $user = User::create([
            'name'         => $request->name,
            'employee_id'  => $request->employee_id,
            'email'        => $request->email,
            'unit'         => $request->unit,
            'department'   => $request->department,
            'manager_id'   => $request->manager_id,
            'designation'  => $request->designation,
            'password'     => Hash::make($request->password),
        ]);

        // Assign roles using Spatie
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

        $user = User::find($id);

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
        $user = User::findOrFail($id);

        // Validate fields except email first
        $request->validate([
            'name'     => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'roles'    => 'required|array',
        ]);

        // Check manually if the email already exists in another user
        if ($request->email !== $user->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);
        }

        // Update user fields
        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Assign roles
        $user->syncRoles($request->roles);

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
