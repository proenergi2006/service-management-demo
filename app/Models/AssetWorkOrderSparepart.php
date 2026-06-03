<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetWorkOrderSparepart extends Model
{
    protected $fillable = [
        'work_order_id',
        'sparepart_id',
        'sparepart_name',
        'unit',
        'qty',
        'unit_price',
        'total_price',
        'vendor_name',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function workOrder()
    {
        return $this->belongsTo(AssetWorkOrder::class, 'work_order_id');
    }

    public function sparepart()
    {
        return $this->belongsTo(AssetSparepart::class, 'sparepart_id');
    }
}