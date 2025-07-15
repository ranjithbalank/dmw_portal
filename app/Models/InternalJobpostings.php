<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalJobpostings extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'job_title',
        'job_description',
        'qualifications',
        'work_experience',
        'slot_available',
        'unit',
        'division',
        'passing_date',
        'end_date',
        'status',
    ];
}
