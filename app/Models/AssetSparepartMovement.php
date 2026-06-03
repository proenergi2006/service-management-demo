<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetSparepartMovement extends Model
{
    protected $fillable = [
        'sparepart_id',
        'movement_type',
        'qty',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'movement_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'stock_before' => 'decimal:2',
        'stock_after' => 'decimal:2',
        'movement_date' => 'date',
    ];

    public function sparepart()
    {
        return $this->belongsTo(AssetSparepart::class, 'sparepart_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}