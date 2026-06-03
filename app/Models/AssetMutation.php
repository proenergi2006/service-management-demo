<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'from_location_id',
        'to_location_id',
        'from_user_id',
        'to_user_id',
        'created_by',
        'mutation_type',
        'mutation_date',
        'remarks',
    ];

    protected $casts = [
        'mutation_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function fromLocation()
    {
        return $this->belongsTo(AssetLocation::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(AssetLocation::class, 'to_location_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}