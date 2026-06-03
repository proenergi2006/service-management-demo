<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAudit;
use App\Models\AssetAuditItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssetAuditScanController extends Controller
{
    public function create(AssetAudit $audit)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');

        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK']) && $audit->owner_role !== $userRole) {
            abort(403, 'Anda tidak memiliki akses ke audit ini.');
        }

        return view('assets.audits.scan', compact('audit'));
    }

    public function store(Request $request, AssetAudit $audit)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');
    
        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK']) && $audit->owner_role !== $userRole) {
            abort(403, 'Anda tidak memiliki akses ke audit ini.');
        }
    
        $validated = $request->validate([
            'qr_code' => ['required', 'string'],
            'audit_status' => ['required', Rule::in(['found', 'damaged', 'need_review', 'not_found'])],
            'actual_location' => ['nullable', 'string', 'max:150'],
            'actual_holder' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
        ]);
    
        $scannedValue = trim($validated['qr_code']);
        $qrToken = $scannedValue;
    
        // Jika yang discan berupa URL full, ambil token di bagian paling akhir
        if (filter_var($scannedValue, FILTER_VALIDATE_URL)) {
            $path = parse_url($scannedValue, PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            $qrToken = end($segments);
        }
    
        $asset = Asset::where('qr_code', $qrToken)->first();
    
        if (!$asset) {
            return back()
                ->withErrors(['qr_code' => 'QR Code asset tidak ditemukan.'])
                ->withInput();
        }
    
        $item = AssetAuditItem::where('asset_audit_id', $audit->id)
            ->where('asset_id', $asset->id)
            ->first();
    
        if (!$item) {
            return back()
                ->withErrors(['qr_code' => 'Asset ini tidak termasuk dalam sesi audit ini.'])
                ->withInput();
        }
    
        $item->update([
            'audit_status'    => $validated['audit_status'],
            'checked_at'      => now(),
            'checked_by'      => Auth::id(),
            'scanned_qr_code' => $scannedValue, // simpan hasil scan asli
            'actual_location' => $validated['actual_location'] ?? null,
            'actual_holder'   => $validated['actual_holder'] ?? null,
            'notes'           => $validated['notes'] ?? null,
        ]);
    
        return redirect()
            ->route('assets.audits.show', $audit)
            ->with('success', 'Hasil scan audit berhasil disimpan.');
    }
}