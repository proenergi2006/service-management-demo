<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AssetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);

        foreach ($rows as $row) {
            if (empty($row[0])) {
                continue;
            }

            $categoryName = $row[2] ?? 'General';

            $category = AssetCategory::firstOrCreate(
                ['name' => $categoryName],
                [
                    'code' => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $categoryName), 0, 5))
                ]
            );

            $allowedRoles = ['GA', 'IT', 'LOGISTIK'];
            $ownerRole = strtoupper($row[9] ?? 'GA');

            if (!in_array($ownerRole, $allowedRoles)) {
                $ownerRole = 'GA';
            }

            $qrCode = 'QR-' . strtoupper(uniqid());

            Asset::create([
                'asset_code'       => $row[0],
                'asset_name'       => $row[1],
                'category_id'      => $category->id,
                'brand'            => $row[3] ?? null,
                'model'            => $row[4] ?? null,
                'serial_number'    => $row[5] ?? null,
                'condition_status' => $row[7] ?? 'good',
                'purchase_date'    => !empty($row[8]) ? $row[8] : null,
                'owner_role'       => $ownerRole,
                'qr_code'          => $qrCode,
                'lifecycle_status' => 'in_stock',
                'created_by'       => auth()->id(),
                'updated_by'       => auth()->id(),
            ]);
        }
    }
}