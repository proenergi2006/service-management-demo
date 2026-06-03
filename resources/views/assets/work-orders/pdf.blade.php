<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $workOrder->work_order_no }}</title>

    <style>
        @page {
            margin: 24px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
        }

        .header {
            border-bottom: 3px solid #0B1F3A;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .company {
            font-size: 20px;
            font-weight: bold;
            color: #0B1F3A;
        }

        .subtitle {
            font-size: 11px;
            color: #6B7280;
            margin-top: 3px;
        }

        .title-box {
            background: #0B1F3A;
            color: white;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 12px;
            background: #E0F2FE;
            color: #075985;
            font-size: 10px;
            font-weight: bold;
            margin-top: 6px;
        }

        .section {
            margin-top: 14px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-title {
            background: #F3F4F6;
            padding: 9px 10px;
            font-weight: bold;
            color: #0B1F3A;
            border-bottom: 1px solid #E5E7EB;
        }

        .section-body {
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 7px;
            border: 1px solid #E5E7EB;
            vertical-align: top;
        }

        th {
            background: #F9FAFB;
            font-weight: bold;
            color: #374151;
        }

        .label {
            width: 28%;
            background: #F9FAFB;
            color: #6B7280;
            font-weight: bold;
        }

        .value {
            color: #111827;
            font-weight: normal;
        }

        .text-block {
            line-height: 1.6;
            white-space: pre-line;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
        }

        .cost {
            font-weight: bold;
            color: #047857;
        }

        .danger {
            color: #BE123C;
            font-weight: bold;
        }

        .signature-wrapper {
            margin-top: 28px;
        }

        .signature-box {
            width: 32%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            margin-top: 55px;
            border-top: 1px solid #111827;
            padding-top: 5px;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            font-size: 9px;
            color: #6B7280;
            border-top: 1px solid #E5E7EB;
            padding-top: 6px;
        }
    </style>
</head>

<body>

    <div class="footer">
        Printed by Service Management System - PT Pro Energi | {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="header">
        <div class="company">PT Pro Energi</div>
        <div class="subtitle">Service Management - Asset Maintenance Work Order</div>
    </div>

    <div class="title-box">
        <div class="title">WORK ORDER MAINTENANCE</div>
        <div style="margin-top: 5px;">
            {{ $workOrder->work_order_no }}
        </div>
        <div class="badge">
            Status: {{ strtoupper(str_replace('_', ' ', $workOrder->status)) }}
        </div>
    </div>

    {{-- WORK ORDER INFO --}}
    <div class="section">
        <div class="section-title">1. Work Order Information</div>

        <div class="section-body">
            <table>
                <tr>
                    <td class="label">WO Number</td>
                    <td class="value">{{ $workOrder->work_order_no }}</td>
                    <td class="label">Status</td>
                    <td class="value status">{{ str_replace('_', ' ', $workOrder->status) }}</td>
                </tr>

                <tr>
                    <td class="label">Maintenance Type</td>
                    <td class="value">{{ ucfirst(str_replace('_', ' ', $workOrder->maintenance_type)) }}</td>
                    <td class="label">Priority</td>
                    <td class="value">{{ ucfirst($workOrder->priority ?? '-') }}</td>
                </tr>

                <tr>
                    <td class="label">Requester</td>
                    <td class="value">{{ $workOrder->requester->name ?? '-' }}</td>
                    <td class="label">Technician</td>
                    <td class="value">{{ $workOrder->technician->name ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">Approver</td>
                    <td class="value">{{ $workOrder->approver->name ?? '-' }}</td>
                    <td class="label">Vendor</td>
                    <td class="value">{{ $workOrder->vendor_name ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ASSET INFO --}}
    <div class="section">
        <div class="section-title">2. Asset Information</div>

        <div class="section-body">
            <table>
                <tr>
                    <td class="label">Asset Code</td>
                    <td>{{ $workOrder->asset->asset_code ?? '-' }}</td>
                    <td class="label">Asset Name</td>
                    <td>{{ $workOrder->asset->asset_name ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">Category</td>
                    <td>{{ $workOrder->asset->category->name ?? '-' }}</td>
                    <td class="label">Location</td>
                    <td>{{ $workOrder->asset->location->name ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">Condition</td>
                    <td>{{ ucfirst($workOrder->asset->condition_status ?? '-') }}</td>
                    <td class="label">Lifecycle</td>
                    <td>{{ ucfirst($workOrder->asset->lifecycle_status ?? '-') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- PROBLEM --}}
    <div class="section">
        <div class="section-title">3. Problem Description</div>

        <div class="section-body">
            <div class="text-block">
                {{ $workOrder->problem_description ?? '-' }}
            </div>
        </div>
    </div>

    {{-- DOWNTIME --}}
    <div class="section">
        <div class="section-title">4. Downtime Tracking</div>

        <div class="section-body">
            <table>
                <tr>
                    <td class="label">Breakdown Time</td>
                    <td>{{ $workOrder->breakdown_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td class="label">Repair Started</td>
                    <td>{{ $workOrder->repair_started_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">Repair Finished</td>
                    <td>{{ $workOrder->repair_finished_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td class="label">Repair Duration</td>
                    <td>{{ number_format($workOrder->repair_duration_minutes ?? 0, 0, ',', '.') }} menit</td>
                </tr>

                <tr>
                    <td class="label">Total Downtime</td>
                    <td class="danger">{{ number_format($workOrder->downtime_minutes ?? 0, 0, ',', '.') }} menit</td>
                    <td class="label">Actual Cost</td>
                    <td class="cost">Rp {{ number_format($workOrder->actual_cost ?? 0, 0, ',', '.') }}</td>
                </tr>
            </table>

            @if($workOrder->downtime_notes)
                <div style="margin-top: 8px;" class="text-block">
                    <strong>Downtime Notes:</strong><br>
                    {{ $workOrder->downtime_notes }}
                </div>
            @endif
        </div>
    </div>

    {{-- CHECKLIST --}}
    <div class="section">
        <div class="section-title">5. Checklist Execution</div>

        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Checklist</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 25%;">Notes</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($workOrder->checklistItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->item_name ?? $item->checklist_name ?? '-' }}</td>
                            <td>{{ ($item->is_done ?? $item->is_checked ?? false) ? 'Done' : 'Pending' }}</td>
                            <td>{{ $item->result_notes ?? $item->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;">Belum ada checklist.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SPAREPART --}}
    <div class="section">
        <div class="section-title">6. Sparepart Usage</div>

        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Sparepart</th>
                        <th style="width: 10%;">Qty</th>
                        <th style="width: 10%;">Unit</th>
                        <th style="width: 18%;">Unit Price</th>
                        <th style="width: 18%;">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($workOrder->spareparts as $index => $sparepart)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sparepart->sparepart_name }}</td>
                            <td>{{ number_format($sparepart->qty, 2, ',', '.') }}</td>
                            <td>{{ $sparepart->unit }}</td>
                            <td>Rp {{ number_format($sparepart->unit_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($sparepart->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">Tidak ada sparepart digunakan.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:right;">Total Sparepart Cost</th>
                        <th>
                            Rp {{ number_format($workOrder->spareparts->sum('total_price'), 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- RESOLUTION --}}
    <div class="section">
        <div class="section-title">7. Resolution Notes</div>

        <div class="section-body">
            <div class="text-block">
                {{ $workOrder->resolution_notes ?? '-' }}
            </div>
        </div>
    </div>

    {{-- SIGNATURE --}}
    <div class="signature-wrapper">
        <div class="signature-box">
            <div>Requested By</div>
            <div class="signature-line">
                {{ $workOrder->requester->name ?? '________________' }}
            </div>
        </div>

        <div class="signature-box">
            <div>Technician</div>
            <div class="signature-line">
                {{ $workOrder->technician->name ?? '________________' }}
            </div>
        </div>

        <div class="signature-box">
            <div>Approved By</div>
            <div class="signature-line">
                {{ $workOrder->approver->name ?? '________________' }}
            </div>
        </div>
    </div>

</body>
</html>