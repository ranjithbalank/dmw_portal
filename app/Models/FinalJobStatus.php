<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalJobStatus extends Model
{
    protected $fillable = [
        'ijp_id', 'release_date', 'end_date', 'unit', 'job_title', 'applicant', 'email', 'status',
        'qualifications', 'experience', 'new_or_replacement', 'interview_panel', 'interview_date',
        'interview_result', 'communication_result', 'communication_movement', 'salary_increase',
        'joining_date', 'required_position'
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
