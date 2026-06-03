<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'audit_no',
        'title',
        'owner_role',
        'audit_date',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'audit_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(AssetAuditItem::class, 'asset_audit_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}