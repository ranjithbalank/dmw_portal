<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validate the registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => ['required', 'string', 'max:255'],
            'employee_id'   => ['required', 'string', 'max:20', 'unique:users'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'unit'          => ['required', 'string', 'max:100'],
            'department'    => ['required', 'string', 'max:100'],
            'manager_id'    => ['required', 'string', 'max:255'],
            'doj'           => ['required', 'date'],
            'type_emp'      => ['required', 'in:General,Shift'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    /**
     * Create a new user after valid registration.
     */
    protected function create(array $data)
    {
        // dd($data);
        return User::create([
            'name' => $data['name'],
            'employee_id' => $data['employee_id'],
            'email' => $data['email'],
            'unit' => $data['unit'],
            'department' => $data['department'],
            'manager_id' => $data['manager_id'],
            "doj"        => $data['doj'],
            "type_emp"   => $data['type_emp'],
            'password' => Hash::make($data['password']),

        ]);
    }
}
