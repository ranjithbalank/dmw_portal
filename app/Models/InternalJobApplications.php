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
        "resume_path", // Ensure this matches the column in your migration
        "is_interested",
    ];

    public function job()
    {
        return $this->belongsTo(InternalJobpostings::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

}
