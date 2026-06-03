<?php

namespace Database\Seeders;

use App\Models\AssetChecklistTemplate;
use App\Models\AssetChecklistTemplateItem;
use Illuminate\Database\Seeder;

class AssetChecklistTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'template_code' => 'CHK-AC-001',
                'template_name' => 'Checklist Preventive AC',
                'asset_type' => 'ga_facility',
                'maintenance_type' => 'preventive',
                'items' => [
                    'Cek filter indoor',
                    'Cek freon',
                    'Cek outdoor unit',
                    'Cek suhu ruangan',
                    'Cek kebocoran air',
                    'Bersihkan unit indoor',
                    'Bersihkan unit outdoor',
                ],
            ],
            [
                'template_code' => 'CHK-TRUCK-001',
                'template_name' => 'Checklist Service Truck',
                'asset_type' => 'truck_tank',
                'maintenance_type' => 'service',
                'items' => [
                    'Cek oli mesin',
                    'Cek rem',
                    'Cek ban',
                    'Cek lampu',
                    'Cek tangki',
                    'Cek STNK / KIR',
                    'Catat KM terakhir',
                ],
            ],
            [
                'template_code' => 'CHK-IT-001',
                'template_name' => 'Checklist Maintenance IT Device',
                'asset_type' => 'it_device',
                'maintenance_type' => 'preventive',
                'items' => [
                    'Cek kondisi fisik perangkat',
                    'Cek storage',
                    'Cek antivirus',
                    'Cek update OS',
                    'Cek koneksi jaringan',
                    'Cek performa perangkat',
                ],
            ],
            [
                'template_code' => 'CHK-GENSET-001',
                'template_name' => 'Checklist Maintenance Genset',
                'asset_type' => 'genset',
                'maintenance_type' => 'preventive',
                'items' => [
                    'Cek oli',
                    'Cek coolant',
                    'Cek battery',
                    'Cek fuel level',
                    'Test running',
                    'Catat hour meter',
                ],
            ],
        ];

        foreach ($templates as $templateData) {
            $template = AssetChecklistTemplate::updateOrCreate(
                ['template_code' => $templateData['template_code']],
                [
                    'template_name' => $templateData['template_name'],
                    'asset_type' => $templateData['asset_type'],
                    'maintenance_type' => $templateData['maintenance_type'],
                    'is_active' => true,
                ]
            );

            foreach ($templateData['items'] as $index => $itemName) {
                AssetChecklistTemplateItem::updateOrCreate(
                    [
                        'template_id' => $template->id,
                        'item_name' => $itemName,
                    ],
                    [
                        'sort_order' => $index + 1,
                        'input_type' => 'check',
                        'is_required' => true,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}