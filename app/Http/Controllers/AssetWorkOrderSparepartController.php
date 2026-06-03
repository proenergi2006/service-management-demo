<?php

namespace App\Http\Controllers;

use App\Models\AssetSparepart;
use App\Models\AssetSparepartMovement;
use App\Models\AssetWorkOrder;
use App\Models\AssetWorkOrderSparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssetWorkOrderSparepartController extends Controller
{
    public function store(Request $request, AssetWorkOrder $workOrder)
    {
        $validated = $request->validate([
            'sparepart_id' => ['required', 'exists:asset_spareparts,id'],
            'sparepart_name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'qty' => ['required', 'numeric', 'min:0.01'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $workOrder) {

            $master = AssetSparepart::lockForUpdate()
                ->findOrFail($validated['sparepart_id']);

            if ((float) $master->current_stock < (float) $validated['qty']) {
                throw ValidationException::withMessages([
                    'sparepart_id' => 'Stock sparepart tidak mencukupi. Stock tersedia: '
                        . number_format((float) $master->current_stock, 2, ',', '.')
                        . ' ' . $master->unit,
                ]);
            }

            $unitPrice = (float) ($validated['unit_price'] ?: $master->standard_price);
            $qty = (float) $validated['qty'];

            $stockBefore = (float) $master->current_stock;
            $stockAfter = $stockBefore - $qty;

            AssetWorkOrderSparepart::create([
                'work_order_id' => $workOrder->id,
                'sparepart_id' => $master->id,
                'sparepart_name' => $master->sparepart_name,
                'unit' => $master->unit,
                'qty' => $qty,
                'unit_price' => $unitPrice,
                'total_price' => $qty * $unitPrice,
                'vendor_name' => $validated['vendor_name'] ?? $master->vendor_name,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            AssetSparepartMovement::create([
                'sparepart_id' => $master->id,
                'movement_type' => 'usage_wo',
                'qty' => $qty,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference_type' => AssetWorkOrder::class,
                'reference_id' => $workOrder->id,
                'movement_date' => now()->toDateString(),
                'notes' => 'Usage for WO ' . $workOrder->work_order_no,
                'created_by' => auth()->id(),
            ]);

            $master->update([
                'current_stock' => $stockAfter,
                'updated_by' => auth()->id(),
            ]);

            $this->refreshWorkOrderActualCost($workOrder);

            $workOrder->asset?->logActivity(
                activityType: 'wo_sparepart_added',
                title: 'Sparepart ditambahkan ke Work Order',
                description: $master->sparepart_name . ' ditambahkan ke ' . $workOrder->work_order_no,
                userId: auth()->id(),
                referenceType: AssetWorkOrder::class,
                referenceId: $workOrder->id
            );
        });

        return back()->with('success', 'Sparepart berhasil ditambahkan dan stock otomatis berkurang.');
    }

    public function destroy(AssetWorkOrder $workOrder, AssetWorkOrderSparepart $sparepart)
    {
        if ($sparepart->work_order_id !== $workOrder->id) {
            abort(404);
        }

        DB::transaction(function () use ($workOrder, $sparepart) {

            if ($sparepart->sparepart_id) {
                $master = AssetSparepart::lockForUpdate()
                    ->find($sparepart->sparepart_id);

                if ($master) {
                    $stockBefore = (float) $master->current_stock;
                    $stockAfter = $stockBefore + (float) $sparepart->qty;

                    AssetSparepartMovement::create([
                        'sparepart_id' => $master->id,
                        'movement_type' => 'return_wo',
                        'qty' => $sparepart->qty,
                        'stock_before' => $stockBefore,
                        'stock_after' => $stockAfter,
                        'reference_type' => AssetWorkOrder::class,
                        'reference_id' => $workOrder->id,
                        'movement_date' => now()->toDateString(),
                        'notes' => 'Return usage from WO ' . $workOrder->work_order_no,
                        'created_by' => auth()->id(),
                    ]);

                    $master->update([
                        'current_stock' => $stockAfter,
                        'updated_by' => auth()->id(),
                    ]);
                }
            }

            $sparepart->delete();

            $this->refreshWorkOrderActualCost($workOrder);
        });

        return back()->with('success', 'Sparepart berhasil dihapus dan stock dikembalikan.');
    }

    private function refreshWorkOrderActualCost(AssetWorkOrder $workOrder): void
    {
        $total = $workOrder->spareparts()->sum('total_price');

        $workOrder->update([
            'actual_cost' => $total,
            'updated_by' => auth()->id(),
        ]);
    }
}