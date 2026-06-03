<?php

namespace App\Http\Controllers;

use App\Models\AssetSparepart;
use App\Models\AssetSparepartMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetSparepartMovementController extends Controller
{
    public function store(Request $request, AssetSparepart $sparepart)
    {
        $validated = $request->validate([
            'movement_type' => ['required', 'in:stock_in,stock_out,adjustment'],
            'qty' => ['required', 'numeric', 'min:0'],
            'movement_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $sparepart) {
            $stockBefore = (float) $sparepart->current_stock;

            if ($validated['movement_type'] === 'stock_in') {
                $stockAfter = $stockBefore + (float) $validated['qty'];
            } elseif ($validated['movement_type'] === 'stock_out') {
                $stockAfter = $stockBefore - (float) $validated['qty'];
            } else {
                $stockAfter = (float) $validated['qty'];
            }

            if ($stockAfter < 0) {
                abort(422, 'Stock tidak boleh minus.');
            }

            AssetSparepartMovement::create([
                'sparepart_id' => $sparepart->id,
                'movement_type' => $validated['movement_type'],
                'qty' => $validated['qty'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'movement_date' => $validated['movement_date'],
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $sparepart->update([
                'current_stock' => $stockAfter,
                'updated_by' => auth()->id(),
            ]);
        });

        return back()->with('success', 'Stock movement berhasil disimpan.');
    }
}