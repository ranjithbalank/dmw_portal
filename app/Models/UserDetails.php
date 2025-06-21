<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'division',
        'divcode',
        'status',
    ];

    /**
     * This detail record belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
