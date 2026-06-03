<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestVisit extends Model
{
    protected $fillable = [
        'guest_code',
        'guest_name',
        'company_name',
        'phone',
        'host_name',
        'purpose',
        'branch',
        'vehicle_number',
        'checkin_at',
        'checkout_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'checkin_at' => 'datetime',
        'checkout_at' => 'datetime',
    ];
}