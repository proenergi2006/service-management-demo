<?php

namespace Database\Seeders;

use App\Models\AssetSparepart;
use Illuminate\Database\Seeder;

class AssetSparepartSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['SP-AC-001', 'Freon AC', 'AC', 'kg', 150000],
            ['SP-AC-002', 'Kapasitor AC', 'AC', 'pcs', 125000],
            ['SP-AC-003', 'Filter AC', 'AC', 'pcs', 75000],

            ['SP-TRK-001', 'Oli Mesin Truck', 'Truck', 'liter', 65000],
            ['SP-TRK-002', 'Filter Solar', 'Truck', 'pcs', 175000],
            ['SP-TRK-003', 'Filter Oli', 'Truck', 'pcs', 150000],
            ['SP-TRK-004', 'Kampas Rem', 'Truck', 'set', 850000],

            ['SP-IT-001', 'SSD 512GB', 'IT', 'pcs', 650000],
            ['SP-IT-002', 'RAM 8GB', 'IT', 'pcs', 450000],
            ['SP-IT-003', 'Adaptor Laptop', 'IT', 'pcs', 350000],

            ['SP-GEN-001', 'Oli Genset', 'Genset', 'liter', 75000],
            ['SP-GEN-002', 'Battery Genset', 'Genset', 'pcs', 1200000],
        ];

        foreach ($items as $item) {
            AssetSparepart::updateOrCreate(
                ['sparepart_code' => $item[0]],
                [
                    'sparepart_name' => $item[1],
                    'category' => $item[2],
                    'unit' => $item[3],
                    'standard_price' => $item[4],
                    'is_active' => true,
                ]
            );
        }
    }
}