<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    //
    protected $fillable = [
        'circular_no',
        'circular_date',
        'created_by',
        'file_path',
    ];
}
