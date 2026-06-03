<?php

namespace App\Http\Controllers;

use App\Models\AssetMaintenanceVendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssetMaintenanceVendorController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetMaintenanceVendor::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('vendor_code', 'like', "%{$search}%")
                    ->orWhere('vendor_name', 'like', "%{$search}%")
                    ->orWhere('vendor_type', 'like', "%{$search}%")
                    ->orWhere('pic_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('vendor_type')) {
            $query->where('vendor_type', $request->vendor_type);
        }

        $vendors = $query->latest()->paginate(10)->withQueryString();

        $types = AssetMaintenanceVendor::whereNotNull('vendor_type')
            ->select('vendor_type')
            ->distinct()
            ->orderBy('vendor_type')
            ->pluck('vendor_type');

        return view('assets.vendors.index', compact('vendors', 'types'));
    }

    public function create()
    {
        return view('assets.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_code' => ['required', 'string', 'max:100', 'unique:asset_maintenance_vendors,vendor_code'],
            'vendor_name' => ['required', 'string', 'max:255'],
            'vendor_type' => ['nullable', 'string', 'max:100'],
            'pic_name' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string'],
            'service_scope' => ['nullable', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['rating'] = $validated['rating'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        AssetMaintenanceVendor::create($validated);

        return redirect()
            ->route('assets.vendors.index')
            ->with('success', 'Vendor maintenance berhasil ditambahkan.');
    }

    public function show(AssetMaintenanceVendor $vendor)
    {
        return view('assets.vendors.show', compact('vendor'));
    }

    public function edit(AssetMaintenanceVendor $vendor)
    {
        return view('assets.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, AssetMaintenanceVendor $vendor)
    {
        $validated = $request->validate([
            'vendor_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('asset_maintenance_vendors', 'vendor_code')->ignore($vendor->id),
            ],
            'vendor_name' => ['required', 'string', 'max:255'],
            'vendor_type' => ['nullable', 'string', 'max:100'],
            'pic_name' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string'],
            'service_scope' => ['nullable', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['rating'] = $validated['rating'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['updated_by'] = auth()->id();

        $vendor->update($validated);

        return redirect()
            ->route('assets.vendors.index')
            ->with('success', 'Vendor maintenance berhasil diperbarui.');
    }

    public function destroy(AssetMaintenanceVendor $vendor)
    {
        $vendor->delete();

        return redirect()
            ->route('assets.vendors.index')
            ->with('success', 'Vendor maintenance berhasil dihapus.');
    }
}