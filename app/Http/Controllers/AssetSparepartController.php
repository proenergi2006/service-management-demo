<?php

namespace App\Http\Controllers;

use App\Models\AssetSparepart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssetSparepartController extends Controller
{
    public function index(Request $request)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');
    
        $query = AssetSparepart::query();
    
        /*
        |--------------------------------------------------------------------------
        | FILTER BY ROLE
        |--------------------------------------------------------------------------
        | IT       => SP-IT%
        | GA       => SP-AC% / SP-GA%
        | LOGISTIK => SP-TRK%
        */
    
        if ($userRole === 'IT') {
            $query->where('sparepart_code', 'like', 'SP-IT%');
        }
    
        if ($userRole === 'GA') {
            $query->where(function ($q) {
                $q->where('sparepart_code', 'like', 'SP-AC%')
                  ->orWhere('sparepart_code', 'like', 'SP-GA%');
            });
        }
    
        if ($userRole === 'LOGISTIK') {
            $query->where('sparepart_code', 'like', 'SP-TRK%');
        }
    
        if ($request->filled('search')) {
            $search = trim($request->search);
    
            $query->where(function ($q) use ($search) {
                $q->where('sparepart_code', 'like', "%{$search}%")
                    ->orWhere('sparepart_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('vendor_name', 'like', "%{$search}%");
            });
        }
    
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low_stock') {
                $query->whereColumn('current_stock', '<=', 'minimum_stock');
            }
    
            if ($request->stock_status === 'safe_stock') {
                $query->whereColumn('current_stock', '>', 'minimum_stock');
            }
        }
    
        $spareparts = $query->latest()->paginate(10)->withQueryString();
    
        $categoriesQuery = AssetSparepart::whereNotNull('category');
    
        if ($userRole === 'IT') {
            $categoriesQuery->where('sparepart_code', 'like', 'SP-IT%');
        }
    
        if ($userRole === 'GA') {
            $categoriesQuery->where(function ($q) {
                $q->where('sparepart_code', 'like', 'SP-AC%')
                  ->orWhere('sparepart_code', 'like', 'SP-GA%');
            });
        }
    
        if ($userRole === 'LOGISTIK') {
            $categoriesQuery->where('sparepart_code', 'like', 'SP-TRK%');
        }
    
        $categories = $categoriesQuery
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    
        return view('assets.spareparts.index', compact(
            'spareparts',
            'categories'
        ));
    }

    public function create()
    {
        return view('assets.spareparts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sparepart_code' => ['required', 'string', 'max:100', 'unique:asset_spareparts,sparepart_code'],
            'sparepart_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:50'],
            'standard_price' => ['nullable', 'numeric', 'min:0'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['standard_price'] = $validated['standard_price'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        AssetSparepart::create($validated);

        return redirect()
            ->route('assets.spareparts.index')
            ->with('success', 'Master sparepart berhasil ditambahkan.');
    }

    public function show(AssetSparepart $sparepart)
    {
        $sparepart->load([
            'workOrderSpareparts.workOrder.asset',
            'movements.creator',
        ]);

        return view('assets.spareparts.show', compact('sparepart'));
    }

    public function edit(AssetSparepart $sparepart)
    {
        return view('assets.spareparts.edit', compact('sparepart'));
    }

    public function update(Request $request, AssetSparepart $sparepart)
    {
        $validated = $request->validate([
            'sparepart_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('asset_spareparts', 'sparepart_code')->ignore($sparepart->id),
            ],
            'sparepart_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:50'],
            'standard_price' => ['nullable', 'numeric', 'min:0'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['standard_price'] = $validated['standard_price'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['updated_by'] = auth()->id();

        $sparepart->update($validated);

        return redirect()
            ->route('assets.spareparts.index')
            ->with('success', 'Master sparepart berhasil diperbarui.');
    }

    public function destroy(AssetSparepart $sparepart)
    {
        $sparepart->delete();

        return redirect()
            ->route('assets.spareparts.index')
            ->with('success', 'Master sparepart berhasil dihapus.');
    }
}