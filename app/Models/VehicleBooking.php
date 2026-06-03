<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleBooking extends Model
{
    protected $fillable = [
        'booking_number',
        'vehicle_id',
        'user_id',
        'requester_name',
        'requester_email',
        'department',
        'branch',
        'destination',
        'purpose',
        'driver_source',
        'driver_name',
        'driver_phone',
        'departure_datetime',
        'return_datetime',
        'passenger_count',
        'passenger_names',
        'status',
        'approved_by',
        'approved_at',
        'approval_note',
        'actual_departure_at',
        'actual_return_at',
        'start_odometer',
        'end_odometer',
        'fuel_cost',
        'parking_cost',
        'toll_cost',
        'other_cost',
        'cancelled_by',
        'cancelled_at',
        'cancel_reason',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'departure_datetime' => 'datetime',
        'return_datetime' => 'datetime',
        'approved_at' => 'datetime',
        'actual_departure_at' => 'datetime',
        'actual_return_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'fuel_cost' => 'decimal:2',
        'parking_cost' => 'decimal:2',
        'toll_cost' => 'decimal:2',
        'other_cost' => 'decimal:2',
    ];

    public function vehicle()
    {
        return $this->belongsTo(MasterVehicle::class, 'vehicle_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}