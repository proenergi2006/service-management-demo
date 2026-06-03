<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_code',
        'asset_name',
        'category_id',
        'location_id',
        'owner_role',
        'brand',
        'model',
        'serial_number',
        'qr_code',
        'purchase_date',
        'received_date',
        'warranty_start_date',
        'warranty_end_date',
        'condition_status',
        'lifecycle_status',
        'syop_pr_no',
        'syop_po_no',
        'accurate_asset_id',
        'description',
        'notes',
        'created_by',
        'updated_by',
        'asset_type',
        'plate_number',
        'engine_number',
        'chassis_number',
        'capacity',
        'capacity_unit',
        'stnk_expired_date',
        'kir_expired_date',
        'insurance_expired_date',
        'fuel_type',
        'odometer',
        'service_interval_km',
        'last_service_date',
        'next_service_date',
        'facility_area',
        'floor',
        'room_name',
        'meter_type',
'current_meter',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'received_date' => 'date',
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
        'stnk_expired_date' => 'date',
        'kir_expired_date' => 'date',
        'insurance_expired_date' => 'date',
        'last_service_date' => 'date',
        'next_service_date' => 'date',
        'capacity' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(AssetLocation::class, 'location_id');
    }

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class, 'asset_id');
    }

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class, 'asset_id');
    }

    public function mutations()
    {
        return $this->hasMany(AssetMutation::class, 'asset_id');
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class, 'asset_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'asset_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function activeAssignment()
    {
        return $this->hasOne(AssetAssignment::class, 'asset_id')
            ->where('status', 'active')
            ->latestOfMany();
    }

    public function activityLogs()
{
    return $this->hasMany(\App\Models\AssetActivityLog::class, 'asset_id')->latest();
}

public function logActivity(
    string $activityType,
    string $title,
    ?string $description = null,
    ?int $userId = null,
    ?string $referenceType = null,
    ?int $referenceId = null,
    ?array $meta = null
) {
    return $this->activityLogs()->create([
        'user_id' => $userId,
        'activity_type' => $activityType,
        'title' => $title,
        'description' => $description,
        'reference_type' => $referenceType,
        'reference_id' => $referenceId,
        'meta' => $meta,
    ]);
}

public function auditItems()
{
    return $this->hasMany(\App\Models\AssetAuditItem::class, 'asset_id');
}

public function workOrders()
{
    return $this->hasMany(\App\Models\AssetWorkOrder::class, 'asset_id');
}

public function maintenanceSchedules()
{
    return $this->hasMany(\App\Models\AssetMaintenanceSchedule::class, 'asset_id');
}

public function meterReadings()
{
    return $this->hasMany(
        \App\Models\AssetMeterReading::class,
        'asset_id'
    )->latest('reading_date');
}
}