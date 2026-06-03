<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    protected $fillable = [
        'booking_number',
        'room_id',
        'user_id',
        'requester_name',
        'requester_email',
        'department',
        'title',
        'purpose',
        'booking_date',
        'start_time',
        'end_time',
        'participant_count',
        'additional_facilities',
        'status',
        'approved_by',
        'approved_at',
        'approval_note',
        'cancelled_by',
        'cancelled_at',
        'cancel_reason',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'additional_facilities' => 'array',
        'approved_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(MasterRoom::class, 'room_id');
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