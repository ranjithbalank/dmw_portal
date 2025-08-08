<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUnitPermission extends Model
{
    protected $fillable = ['role_id', 'unit_id', 'permission'];
}
