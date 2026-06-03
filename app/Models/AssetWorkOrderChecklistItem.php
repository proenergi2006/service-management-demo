<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetWorkOrderChecklistItem extends Model
{
    protected $fillable = [
        'work_order_id',
        'template_item_id',
        'sort_order',
        'item_name',
        'item_description',
        'input_type',
        'is_required',
        'result_value',
        'result_notes',
        'is_done',
        'checked_by',
        'checked_at',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_done' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function workOrder()
    {
        return $this->belongsTo(AssetWorkOrder::class, 'work_order_id');
    }

    public function templateItem()
    {
        return $this->belongsTo(AssetChecklistTemplateItem::class, 'template_item_id');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}