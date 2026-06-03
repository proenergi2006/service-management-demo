<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterVehicle extends Model
{
    protected $fillable = [
        'vehicle_code',
        'plate_number',
        'vehicle_name',
        'brand',
        'model',
        'type',
        'capacity',
        'ownership_status',
        'branch',
        'location',
        'vehicle_status',
        'stnk_expired_date',
        'kir_expired_date',
        'insurance_expired_date',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'stnk_expired_date' => 'date',
        'kir_expired_date' => 'date',
        'insurance_expired_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(VehicleBooking::class, 'vehicle_id');
    }
}