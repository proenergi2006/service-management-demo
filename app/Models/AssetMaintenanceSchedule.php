<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMaintenanceSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asset_id',
        'schedule_no',
        'maintenance_type',
        'schedule_name',
        'description',
        'frequency_type',
        'frequency_interval',
        'start_date',
        'last_execution_date',
        'next_execution_date',
        'last_meter',
        'next_meter',
        'reminder_days_before',
        'priority',
        'assigned_to',
        'vendor_name',
        'estimated_cost',
        'auto_generate_wo',
        'last_work_order_id',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_execution_date' => 'date',
        'next_execution_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'auto_generate_wo' => 'boolean',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function lastWorkOrder()
    {
        return $this->belongsTo(AssetWorkOrder::class, 'last_work_order_id');
    }

    public function isDue(): bool
    {
        if ($this->frequency_type === 'km' || $this->frequency_type === 'hour_meter') {
            return false;
        }

        return $this->next_execution_date
            && $this->next_execution_date->lte(now()->toDateString());
    }

    public function isUpcoming(): bool
    {
        if (!$this->next_execution_date) {
            return false;
        }

        return $this->next_execution_date
            ->lte(now()->addDays($this->reminder_days_before)->toDateString());
    }
}