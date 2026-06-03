<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetChecklistTemplateItem extends Model
{
    protected $fillable = [
        'template_id',
        'sort_order',
        'item_name',
        'item_description',
        'input_type',
        'is_required',
        'is_active',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(AssetChecklistTemplate::class, 'template_id');
    }
}