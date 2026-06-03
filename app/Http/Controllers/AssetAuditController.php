<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAudit;
use App\Models\AssetAuditItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AssetAuditController extends Controller
{
    public function index()
    {
        $userRole = strtoupper(auth()->user()->role ?? '');

        $query = AssetAudit::withCount('items')->latest();

        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK'])) {
            $query->where('owner_role', $userRole);
        }

        $audits = $query->paginate(10);

        return view('assets.audits.index', compact('audits'));
    }

    public function create()
    {
        return view('assets.audits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'audit_name' => ['required', 'string', 'max:200'],
            'owner_role' => ['required', Rule::in(['IT', 'GA', 'LOGISTIK'])],
            'audit_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ]);
    
        $auditCode = 'AUD-' . now()->format('Ymd-His');
    
        $auditId = DB::table('asset_audits')->insertGetId([
            'audit_code'  => $auditCode,
            'audit_name'  => $validated['audit_name'],
            'owner_role'  => $validated['owner_role'],
            'audit_date'  => $validated['audit_date'],
            'status'      => 'open',
            'description' => $validated['description'] ?? null,
            'created_by'  => Auth::id(),
            'updated_by'  => Auth::id(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    
        $audit = AssetAudit::findOrFail($auditId);
    
        $assets = Asset::where('owner_role', $validated['owner_role'])->get();
    
        foreach ($assets as $asset) {
            AssetAuditItem::create([
                'asset_audit_id' => $audit->id,
                'asset_id'       => $asset->id,
                'audit_status'   => 'pending',
            ]);
        }
    
        return redirect()
            ->route('assets.audits.show', $audit)
            ->with('success', 'Sesi audit berhasil dibuat.');
    }

    public function show(AssetAudit $audit)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');

        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK']) && $audit->owner_role !== $userRole) {
            abort(403, 'Anda tidak memiliki akses ke audit ini.');
        }

        $audit->load([
            'items.asset.category',
            'items.asset.location',
            'items.asset.activeAssignment.user',
            'items.checker',
        ]);

        $summary = [
            'total' => $audit->items->count(),
            'found' => $audit->items->where('audit_status', 'found')->count(),
            'not_found' => $audit->items->where('audit_status', 'not_found')->count(),
            'damaged' => $audit->items->where('audit_status', 'damaged')->count(),
            'pending' => $audit->items->where('audit_status', 'pending')->count(),
        ];

        return view('assets.audits.show', compact('audit', 'summary'));
    }

    public function updateItem(Request $request, AssetAudit $audit, AssetAuditItem $item)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');

        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK']) && $audit->owner_role !== $userRole) {
            abort(403, 'Anda tidak memiliki akses ke audit ini.');
        }

        abort_if($item->asset_audit_id !== $audit->id, 404);

        $validated = $request->validate([
            'audit_status' => ['required', Rule::in(['pending', 'found', 'not_found', 'damaged', 'need_review'])],
            'actual_location' => ['nullable', 'string', 'max:150'],
            'actual_holder' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
            'scanned_qr_code' => ['nullable', 'string', 'max:150'],
        ]);

        $item->update([
            'audit_status'   => $validated['audit_status'],
            'actual_location'=> $validated['actual_location'] ?? null,
            'actual_holder'  => $validated['actual_holder'] ?? null,
            'notes'          => $validated['notes'] ?? null,
            'scanned_qr_code'=> $validated['scanned_qr_code'] ?? null,
            'checked_by'     => Auth::id(),
            'checked_at'     => now(),
        ]);

        return back()->with('success', 'Hasil audit asset berhasil diperbarui.');
    }
}