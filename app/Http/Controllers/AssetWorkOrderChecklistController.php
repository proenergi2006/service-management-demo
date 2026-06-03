<?php

namespace App\Http\Controllers;

use App\Models\AssetWorkOrder;
use App\Models\AssetChecklistTemplate;
use App\Models\AssetWorkOrderChecklistItem;
use Illuminate\Http\Request;

class AssetWorkOrderChecklistController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ATTACH TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function attachTemplate(
        Request $request,
        AssetWorkOrder $workOrder
    ) {

        $validated = $request->validate([
            'template_id' => [
                'required',
                'exists:asset_checklist_templates,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | AVOID DUPLICATE
        |--------------------------------------------------------------------------
        */

        if ($workOrder->checklistItems()->exists()) {

            return back()->with(
                'error',
                'Checklist sudah terpasang pada Work Order.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD TEMPLATE
        |--------------------------------------------------------------------------
        */

        $template = AssetChecklistTemplate::with([
            'items',
        ])->findOrFail(
            $validated['template_id']
        );

        /*
        |--------------------------------------------------------------------------
        | COPY TEMPLATE ITEMS
        |--------------------------------------------------------------------------
        */

        foreach ($template->items as $item) {

            AssetWorkOrderChecklistItem::create([

                'work_order_id' => $workOrder->id,

                'template_item_id' => $item->id,

                'sort_order' => $item->sort_order,

                'item_name' => $item->item_name,

                'item_description' => $item->item_description,

                'input_type' => $item->input_type,

                'is_required' => $item->is_required,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOG
        |--------------------------------------------------------------------------
        */

        $workOrder->asset?->logActivity(

            activityType: 'wo_checklist_attached',

            title: 'Checklist Template dipasang',

            description:
                'Checklist template "' .
                $template->template_name .
                '" dipasang ke Work Order.',

            userId: auth()->id(),

            referenceType: AssetWorkOrder::class,

            referenceId: $workOrder->id
        );

        return back()->with(
            'success',
            'Checklist template berhasil dipasang.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CHECKLIST ITEM
    |--------------------------------------------------------------------------
    */

    public function updateItem(
        Request $request,
        AssetWorkOrderChecklistItem $item
    ) {

        $validated = $request->validate([

            'result_value' => [
                'nullable',
                'string',
                'max:255',
            ],

            'result_notes' => [
                'nullable',
                'string',
            ],

            'is_done' => [
                'nullable',
                'boolean',
            ],
        ]);

        $item->update([

            'result_value' => $validated['result_value'] ?? null,

            'result_notes' => $validated['result_notes'] ?? null,

            'is_done' => $request->boolean('is_done'),

            'checked_by' => auth()->id(),

            'checked_at' => now(),
        ]);

        return back()->with(
            'success',
            'Checklist berhasil diperbarui.'
        );
    }
}