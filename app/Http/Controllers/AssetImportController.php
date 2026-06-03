<?php

namespace App\Http\Controllers;

use App\Imports\AssetImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetImportController extends Controller
{
    public function downloadTemplate($type)
    {
        $headers = [];
        $rows = [];

        if ($type === 'it') {

            $headers = [
                'asset_code',
                'asset_name',
                'category',
                'brand',
                'model',
                'serial_number',
                'location',
                'condition_status',
                'purchase_date',
                'owner_role',
            ];

            $rows[] = [
                'IT-0001',
                'Laptop Dell Latitude',
                'Laptop',
                'Dell',
                'Latitude 5420',
                'SN123456',
                'Head Office',
                'good',
                '2026-01-10',
                'IT',
            ];
        }

        elseif ($type === 'ga') {

            $headers = [
                'asset_code',
                'asset_name',
                'category',
                'brand',
                'location',
                'condition_status',
                'owner_role',
            ];

            $rows[] = [
                'GA-0001',
                'AC Ruang Meeting',
                'Elektronik',
                'Daikin',
                'Meeting Room',
                'good',
                'GA',
            ];
        }

        elseif ($type === 'logistik') {

            $headers = [
                'asset_code',
                'asset_name',
                'plate_number',
                'brand',
                'type',
                'capacity',
                'location',
                'condition_status',
                'owner_role',
            ];

            $rows[] = [
                'TRK-0001',
                'Truck Tangki 8000L',
                'B 1234 ABC',
                'Hino',
                'Tank Truck',
                '8000',
                'Jakarta',
                'good',
                'Logistik',
            ];
        }

        return Excel::download(
            new \App\Exports\ArrayExport($headers, $rows),
            "template_asset_{$type}.xlsx"
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new AssetImport, $request->file('file'));

        return back()->with('success', 'Import asset berhasil.');
    }
}