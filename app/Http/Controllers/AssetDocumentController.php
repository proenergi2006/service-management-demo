<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AssetDocumentController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'document_type' => ['required', Rule::in(['invoice', 'photo', 'warranty', 'manual', 'bast', 'other'])],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx', 'max:5120'],
            'notes' => ['nullable', 'string'],
        ]);

        $file = $request->file('file');

        $path = $file->store('asset-documents/' . $asset->id, 'public');

        $document = AssetDocument::create([
            'asset_id' => $asset->id,
            'document_type' => $validated['document_type'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_mime' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        $asset->logActivity(
            activityType: 'document_uploaded',
            title: 'Dokumen diupload',
            description: 'Dokumen ' . $document->file_name . ' berhasil diupload.',
            userId: Auth::id(),
            referenceType: 'asset_document',
            referenceId: $document->id,
            meta: [
                'document_type' => $document->document_type,
                'file_name' => $document->file_name,
            ]
        );

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Dokumen asset berhasil diupload.');
    }

    public function destroy(Asset $asset, AssetDocument $document)
    {
        abort_if($document->asset_id !== $asset->id, 404);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $asset->logActivity(
            activityType: 'document_deleted',
            title: 'Dokumen dihapus',
            description: 'Dokumen ' . $document->file_name . ' telah dihapus.',
            userId: Auth::id(),
            referenceType: 'asset_document',
            referenceId: $document->id,
            meta: [
                'document_type' => $document->document_type,
                'file_name' => $document->file_name,
            ]
        );

        $document->delete();

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Dokumen asset berhasil dihapus.');
    }
}