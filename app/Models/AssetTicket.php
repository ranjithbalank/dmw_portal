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
        'closed_reason',
        'reopened_reason',
        'status',
    ];

    /**
     * The user who created the ticket.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user who is assigned to this ticket.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * The user who last changed this ticket.
     */
    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * The user who closed this ticket.
     */
    public function closer()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * The user who reopened this ticket.
     */
    public function reopener()
    {
        return $this->belongsTo(User::class, 'reopened_by');
    }
}
