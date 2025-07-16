<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalJobApplications extends Model
{
    //
    protected $fillable = [
        "employee_id",
        "emp_qualifications",
        "emp_experience",
        "job_id",
    ];
}
