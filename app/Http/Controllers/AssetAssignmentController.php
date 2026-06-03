<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\AssetMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssetAssignmentController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'assigned_date' => ['required', 'date'],
            'expected_return_date' => ['nullable', 'date', 'after_or_equal:assigned_date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $currentAssignment = $asset->assignments()
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($currentAssignment) {
            return back()->withErrors([
                'assignment' => 'Asset ini masih memiliki assignment aktif.',
            ])->withInput();
        }

        AssetAssignment::create([
            'asset_id' => $asset->id,
            'user_id' => $validated['user_id'],
            'assigned_by' => Auth::id(),
            'assigned_date' => $validated['assigned_date'],
            'expected_return_date' => $validated['expected_return_date'] ?? null,
            'status' => 'active',
            'remarks' => $validated['remarks'] ?? null,
        ]);

        $assignedUser = \App\Models\User::find($validated['user_id']);

        $asset->logActivity(
            activityType: 'assigned',
            title: 'Asset di-assign',
            description: 'Asset diassign ke ' . ($assignedUser->name ?? 'user') . '.',
            userId: Auth::id(),
            referenceType: 'asset_assignment',
            referenceId: $assignment->id,
            meta: [
                'assigned_to' => $assignedUser->name ?? null,
                'assigned_date' => $validated['assigned_date'],
            ]
        );

        AssetMutation::create([
            'asset_id' => $asset->id,
            'from_location_id' => $asset->location_id,
            'to_location_id' => $asset->location_id,
            'from_user_id' => optional($currentAssignment)->user_id,
            'to_user_id' => $validated['user_id'],
            'created_by' => Auth::id(),
            'mutation_type' => 'handover_user',
            'mutation_date' => $validated['assigned_date'],
            'remarks' => $validated['remarks'] ?? 'Assignment asset',
        ]);

        $asset->update([
            'lifecycle_status' => 'assigned',
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Asset berhasil di-assign ke user.');
    }

    public function returnAsset(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'returned_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
            'next_status' => ['nullable', Rule::in(['in_stock', 'maintenance', 'disposed'])],
        ]);

        $assignment = $asset->assignments()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$assignment) {
            return back()->withErrors([
                'assignment' => 'Tidak ada assignment aktif untuk asset ini.',
            ]);
        }

        $assignment->update([
            'returned_date' => $validated['returned_date'],
            'status' => 'returned',
            'remarks' => $validated['remarks'] ?? $assignment->remarks,
        ]);

        $asset->logActivity(
            activityType: 'returned',
            title: 'Asset dikembalikan',
            description: 'Asset telah dikembalikan dari user sebelumnya.',
            userId: Auth::id(),
            referenceType: 'asset_assignment',
            referenceId: $assignment->id,
            meta: [
                'returned_date' => $validated['returned_date'],
                'next_status' => $validated['next_status'] ?? 'in_stock',
            ]
        );

        AssetMutation::create([
            'asset_id' => $asset->id,
            'from_location_id' => $asset->location_id,
            'to_location_id' => $asset->location_id,
            'from_user_id' => $assignment->user_id,
            'to_user_id' => null,
            'created_by' => Auth::id(),
            'mutation_type' => 'handover_user',
            'mutation_date' => $validated['returned_date'],
            'remarks' => $validated['remarks'] ?? 'Return asset',
        ]);

        $asset->update([
            'lifecycle_status' => $validated['next_status'] ?? 'in_stock',
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Asset berhasil dikembalikan.');
    }
}