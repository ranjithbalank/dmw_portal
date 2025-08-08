<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the permissions associated with the module.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Get the units associated with the module.
     */
    public function units()
    {
        return $this->hasMany(unit::class);
    }
}
