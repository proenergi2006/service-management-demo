<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMaintenanceVendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_code',
        'vendor_name',
        'vendor_type',
        'pic_name',
        'phone',
        'email',
        'address',
        'service_scope',
        'rating',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}