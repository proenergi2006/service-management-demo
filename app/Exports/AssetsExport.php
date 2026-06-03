<?php

namespace App\Exports;

use App\Models\Asset;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = Asset::with([
            'category',
            'location',
            'activeAssignment.user',
        ]);

        if (!empty($this->filters['search'])) {
            $search = trim($this->filters['search']);

            $query->where(function ($q) use ($search) {
                $q->where('asset_code', 'like', "%{$search}%")
                    ->orWhere('asset_name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['category_id'])) {
            $query->where('category_id', $this->filters['category_id']);
        }

        if (!empty($this->filters['location_id'])) {
            $query->where('location_id', $this->filters['location_id']);
        }

        if (!empty($this->filters['lifecycle_status'])) {
            $query->where('lifecycle_status', $this->filters['lifecycle_status']);
        }

        if (!empty($this->filters['condition_status'])) {
            $query->where('condition_status', $this->filters['condition_status']);
        }

        return $query->orderBy('asset_code')->get()->map(function ($asset, $index) {
            return [
                'No' => $index + 1,
                'Asset Code' => $asset->asset_code,
                'Asset Name' => $asset->asset_name,
                'Category' => $asset->category->name ?? '-',
                'Location' => $asset->location->name ?? '-',
                'Holder' => $asset->activeAssignment?->user?->name ?? '-',
                'Brand' => $asset->brand ?? '-',
                'Model' => $asset->model ?? '-',
                'Serial Number' => $asset->serial_number ?? '-',
                'QR Code' => $asset->qr_code ?? '-',
                'Purchase Date' => optional($asset->purchase_date)?->format('Y-m-d') ?? '-',
                'Received Date' => optional($asset->received_date)?->format('Y-m-d') ?? '-',
                'Warranty Start' => optional($asset->warranty_start_date)?->format('Y-m-d') ?? '-',
                'Warranty End' => optional($asset->warranty_end_date)?->format('Y-m-d') ?? '-',
                'Condition Status' => ucfirst($asset->condition_status),
                'Lifecycle Status' => ucfirst(str_replace('_', ' ', $asset->lifecycle_status)),
                'SYOP PR No' => $asset->syop_pr_no ?? '-',
                'SYOP PO No' => $asset->syop_po_no ?? '-',
                'Accurate Asset ID' => $asset->accurate_asset_id ?? '-',
                'Description' => $asset->description ?? '-',
                'Notes' => $asset->notes ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Asset Code',
            'Asset Name',
            'Category',
            'Location',
            'Holder',
            'Brand',
            'Model',
            'Serial Number',
            'QR Code',
            'Purchase Date',
            'Received Date',
            'Warranty Start',
            'Warranty End',
            'Condition Status',
            'Lifecycle Status',
            'SYOP PR No',
            'SYOP PO No',
            'Accurate Asset ID',
            'Description',
            'Notes',
        ];
    }
}