<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Get employee ID from Excel heading 'employee_id'
        $employeeId = $row['employee_id'] ?? null;

        if (!$employeeId) {
            return null; // skip this row if no employee_id
        }

        return User::updateOrCreate(
            ['employee_id' => $employeeId], // this is the unique key to find existing user
            [
                'name'          => $row['name'],
                'email'         => $row['email'],
                'designation'   => $row['designation'],
                'unit'          => $row['unit'],
                'department'    => $row['department'],
                'doj'           => $row['doj'], // make sure date format matches DB or parse it
                'type_emp'      => $row['type_emp'],
                'manager_id'    => $row['manager_id'] ?: null,
                'leave_balance' => $row['leave_balance'] ?: 20.0,
                'status'        => $row['status'] ?: 'active',

                // Optional: only set password if creating new user
                'password'      => Hash::make('password123'),
            ]
        );
    }
}
