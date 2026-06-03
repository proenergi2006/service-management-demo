<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'site',
        'building',
        'floor',
        'room',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'location_id');
    }
}