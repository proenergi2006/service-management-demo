<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMeterReading;
use Illuminate\Http\Request;

class AssetMeterReadingController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([

            'meter_type' => [
                'required',
                'in:km,hour_meter,runtime',
            ],

            'meter_value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'reading_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $validated['asset_id'] = $asset->id;

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $reading = AssetMeterReading::create($validated);

        /*
        |--------------------------------------------------------------------------
        | UPDATE ASSET LAST METER
        |--------------------------------------------------------------------------
        */

        if (
            in_array($validated['meter_type'], [
                'km',
                'hour_meter',
            ])
        ) {

            $asset->update([
                'current_meter' => $validated['meter_value'],
                'updated_by' => auth()->id(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOG
        |--------------------------------------------------------------------------
        */

        $asset->logActivity(
            activityType: 'meter_reading',
            title: 'Meter Reading ditambahkan',
            description:
                strtoupper($validated['meter_type']) .
                ' : ' .
                number_format($validated['meter_value'], 0, ',', '.'),
            userId: auth()->id(),
            referenceType: AssetMeterReading::class,
            referenceId: $reading->id
        );

        return back()->with(
            'success',
            'Meter reading berhasil ditambahkan.'
        );
    }
}