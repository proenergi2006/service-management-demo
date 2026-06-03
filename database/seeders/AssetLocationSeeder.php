<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetLocation;

class AssetLocationSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'code' => 'HO-JKT',
                'name' => 'Head Office Jakarta',
                'site' => 'Jakarta',
                'building' => 'Main Office',
                'floor' => '3',
                'room' => 'IT Room',
            ],
            [
                'code' => 'WH-JKT',
                'name' => 'Warehouse Jakarta',
                'site' => 'Jakarta',
                'building' => null,
                'floor' => null,
                'room' => 'Gudang',
            ],
        ];

        foreach ($rows as $row) {
            AssetLocation::updateOrCreate(
                ['code' => $row['code']],
                [
                    'name' => $row['name'],
                    'site' => $row['site'],
                    'building' => $row['building'],
                    'floor' => $row['floor'],
                    'room' => $row['room'],
                    'description' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}