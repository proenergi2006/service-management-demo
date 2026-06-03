<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRoom extends Model
{
    protected $fillable = [
        'room_code',
        'room_name',
        'location',
        'floor',
        'capacity',
        'facilities',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(RoomBooking::class, 'room_id');
    }
}