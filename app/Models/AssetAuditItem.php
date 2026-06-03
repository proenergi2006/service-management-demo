<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAuditItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_audit_id',
        'asset_id',
        'audit_result',
        'actual_location',
        'actual_holder_name',
        'notes',
        'scanned_at',
        'scanned_by',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function audit()
    {
        return $this->belongsTo(AssetAudit::class, 'asset_audit_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}