<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetChecklistTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_code',
        'template_name',
        'asset_type',
        'maintenance_type',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(AssetChecklistTemplateItem::class, 'template_id')
            ->orderBy('sort_order');
    }
}