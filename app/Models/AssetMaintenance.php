<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'ticket_id',
        'requested_by',
        'handled_by',
        'maintenance_no',
        'maintenance_type',
        'request_date',
        'schedule_date',
        'start_date',
        'finish_date',
        'status',
        'cost',
        'issue_description',
        'action_taken',
        'result_notes',
    ];

    protected $casts = [
        'request_date' => 'date',
        'schedule_date' => 'date',
        'start_date' => 'date',
        'finish_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}