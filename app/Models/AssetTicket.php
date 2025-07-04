<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'priority',
        'unit',
        'division',
        'created_by',
        'assigned_to',
        'assigned_on',
        'changed_by',
        'changed_on',
        'closed_by',
        'closed_on',
        'reopened_by',
        'reopened_on',
        'status'
    ];
}
