<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetSparepart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sparepart_code',
        'sparepart_name',
        'category',
        'unit',
        'standard_price',
        'vendor_name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'current_stock',
'minimum_stock',
    ];

    protected $casts = [
        'standard_price' => 'decimal:2',
        'is_active' => 'boolean',
        'current_stock' => 'decimal:2',
'minimum_stock' => 'decimal:2',
    ];

    public function workOrderSpareparts()
    {
        return $this->hasMany(AssetWorkOrderSparepart::class, 'sparepart_id');
    }

    public function movements()
{
    return $this->hasMany(\App\Models\AssetSparepartMovement::class, 'sparepart_id')
        ->latest('movement_date');
}

public function isLowStock(): bool
{
    return $this->current_stock <= $this->minimum_stock;
}
}