<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetCategory;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'LAPTOP', 'name' => 'Laptop'],
            ['code' => 'PRINTER', 'name' => 'Printer'],
            ['code' => 'MONITOR', 'name' => 'Monitor'],
            ['code' => 'NETWORK', 'name' => 'Perangkat Jaringan'],
            ['code' => 'AC', 'name' => 'Air Conditioner'],
            ['code' => 'VEHICLE', 'name' => 'Kendaraan'],
            ['code' => 'SPAREPART', 'name' => 'Sparepart'],
        ];

        foreach ($rows as $row) {
            AssetCategory::updateOrCreate(
                ['code' => $row['code']],
                [
                    'name' => $row['name'],
                    'description' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}