<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetMeterReading extends Model
{
    protected $fillable = [

        'asset_id',

        'meter_type',
        'meter_value',

        'reading_date',

        'notes',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'reading_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(
            Asset::class,
            'asset_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function updater()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }
}