<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetWorkOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asset_id',
        'work_order_no',
        'maintenance_type',
        'priority',
        'problem_description',
        'root_cause',
        'repair_action',
        'requested_by',
        'assigned_to',
        'status',
        'approved_by',
        'approved_at',
        'approval_note',
        'planned_start_date',
        'planned_finish_date',
        'actual_start_date',
        'actual_finish_date',
        'estimated_cost',
        'actual_cost',
        'vendor_name',
        'vendor_pic',
        'vendor_phone',
        'start_meter',
        'end_meter',
        'attachment',
        'notes',
        'created_by',
        'updated_by',
        'breakdown_at',
'repair_started_at',
'repair_finished_at',
'repair_duration_minutes',
'downtime_minutes',
'downtime_notes',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'planned_start_date' => 'datetime',
        'planned_finish_date' => 'datetime',
        'actual_start_date' => 'datetime',
        'actual_finish_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'breakdown_at' => 'datetime',
'repair_started_at' => 'datetime',
'repair_finished_at' => 'datetime',
'repair_duration_minutes' => 'integer',
'downtime_minutes' => 'integer',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function checklistItems()
{
    return $this->hasMany(\App\Models\AssetWorkOrderChecklistItem::class, 'work_order_id')
        ->orderBy('sort_order');
}

public function spareparts()
{
    return $this->hasMany(\App\Models\AssetWorkOrderSparepart::class, 'work_order_id');
}
}