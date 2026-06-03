<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssetMaintenanceController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'ticket_id' => ['nullable', 'exists:tickets,id'],
            'maintenance_no' => ['required', 'string', 'max:100', 'unique:asset_maintenances,maintenance_no'],
            'maintenance_type' => ['required', Rule::in(['preventive', 'corrective', 'repair'])],
            'request_date' => ['nullable', 'date'],
            'schedule_date' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'finish_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['open', 'scheduled', 'on_progress', 'done', 'cancelled'])],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'issue_description' => ['nullable', 'string'],
            'action_taken' => ['nullable', 'string'],
            'result_notes' => ['nullable', 'string'],
            'requested_by' => ['nullable', 'exists:users,id'],
            'handled_by' => ['nullable', 'exists:users,id'],
        ]);

        $maintenance = AssetMaintenance::create([
            'asset_id' => $asset->id,
            'ticket_id' => $validated['ticket_id'] ?? null,
            'requested_by' => $validated['requested_by'] ?? Auth::id(),
            'handled_by' => $validated['handled_by'] ?? null,
            'maintenance_no' => $validated['maintenance_no'],
            'maintenance_type' => $validated['maintenance_type'],
            'request_date' => $validated['request_date'] ?? now()->toDateString(),
            'schedule_date' => $validated['schedule_date'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'finish_date' => $validated['finish_date'] ?? null,
            'status' => $validated['status'],
            'cost' => $validated['cost'] ?? null,
            'issue_description' => $validated['issue_description'] ?? null,
            'action_taken' => $validated['action_taken'] ?? null,
            'result_notes' => $validated['result_notes'] ?? null,
        ]);

        $asset->logActivity(
            activityType: 'maintenance_created',
            title: 'Maintenance ditambahkan',
            description: 'Maintenance ' . $maintenance->maintenance_no . ' berhasil dibuat.',
            userId: Auth::id(),
            referenceType: 'asset_maintenance',
            referenceId: $maintenance->id,
            meta: [
                'maintenance_no' => $maintenance->maintenance_no,
                'maintenance_type' => $maintenance->maintenance_type,
                'status' => $maintenance->status,
            ]
        );

        if (in_array($validated['status'], ['open', 'scheduled', 'on_progress'])) {
            $asset->update([
                'lifecycle_status' => 'maintenance',
                'updated_by' => Auth::id(),
            ]);

            AssetMutation::create([
                'asset_id' => $asset->id,
                'from_location_id' => $asset->location_id,
                'to_location_id' => $asset->location_id,
                'from_user_id' => optional($asset->activeAssignment)->user_id,
                'to_user_id' => optional($asset->activeAssignment)->user_id,
                'created_by' => Auth::id(),
                'mutation_type' => 'repair_send',
                'mutation_date' => $validated['start_date'] ?? $validated['request_date'] ?? now()->toDateString(),
                'remarks' => 'Asset masuk maintenance',
            ]);
        }

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Data maintenance berhasil ditambahkan.');
    }

    public function update(Request $request, Asset $asset, AssetMaintenance $maintenance)
    {
        abort_if($maintenance->asset_id !== $asset->id, 404);

        $validated = $request->validate([
            'ticket_id' => ['nullable', 'exists:tickets,id'],
            'maintenance_no' => [
                'required',
                'string',
                'max:100',
                Rule::unique('asset_maintenances', 'maintenance_no')->ignore($maintenance->id),
            ],
            'maintenance_type' => ['required', Rule::in(['preventive', 'corrective', 'repair'])],
            'request_date' => ['nullable', 'date'],
            'schedule_date' => ['nullable', 'date'],
            'start_date' => ['nullable', 'date'],
            'finish_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['open', 'scheduled', 'on_progress', 'done', 'cancelled'])],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'issue_description' => ['nullable', 'string'],
            'action_taken' => ['nullable', 'string'],
            'result_notes' => ['nullable', 'string'],
            'requested_by' => ['nullable', 'exists:users,id'],
            'handled_by' => ['nullable', 'exists:users,id'],
        ]);

        $maintenance->update($validated);

        if ($validated['status'] === 'done') {
            $asset->update([
                'lifecycle_status' => $asset->activeAssignment ? 'assigned' : 'in_stock',
                'condition_status' => 'good',
                'updated_by' => Auth::id(),
            ]);

            AssetMutation::create([
                'asset_id' => $asset->id,
                'from_location_id' => $asset->location_id,
                'to_location_id' => $asset->location_id,
                'from_user_id' => optional($asset->activeAssignment)->user_id,
                'to_user_id' => optional($asset->activeAssignment)->user_id,
                'created_by' => Auth::id(),
                'mutation_type' => 'repair_return',
                'mutation_date' => $validated['finish_date'] ?? now()->toDateString(),
                'remarks' => 'Asset selesai maintenance',
            ]);
        }

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Data maintenance berhasil diperbarui.');
    }

    public function destroy(Asset $asset, AssetMaintenance $maintenance)
    {
        abort_if($maintenance->asset_id !== $asset->id, 404);

        $maintenance->delete();

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Data maintenance berhasil dihapus.');
    }
}