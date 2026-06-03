<?php

namespace App\Console\Commands;

use App\Models\AssetMaintenanceSchedule;
use App\Models\AssetWorkOrder;
use Illuminate\Console\Command;

class GenerateDueMaintenanceWorkOrders extends Command
{
    protected $signature = 'maintenance:generate-due-work-orders';

    protected $description = 'Generate Work Order otomatis dari maintenance schedule yang sudah due';

    public function handle(): int
    {
        $schedules = AssetMaintenanceSchedule::with('asset')
            ->where('status', 'active')
            ->where('auto_generate_wo', true)
            ->whereNotNull('next_execution_date')
            ->whereDate('next_execution_date', '<=', now())
            ->get();

        foreach ($schedules as $schedule) {
            $alreadyExists = AssetWorkOrder::where('asset_id', $schedule->asset_id)
                ->where('notes', 'like', '%' . $schedule->schedule_no . '%')
                ->whereIn('status', ['draft', 'submitted', 'approved', 'scheduled', 'in_progress'])
                ->exists();

            if ($alreadyExists) {
                continue;
            }

            $workOrder = AssetWorkOrder::create([
                'asset_id' => $schedule->asset_id,
                'work_order_no' => $this->generateWorkOrderNo(),

                'maintenance_type' => match ($schedule->maintenance_type) {
                    'inspection' => 'inspection',
                    'calibration' => 'calibration',
                    default => 'preventive',
                },

                'priority' => $schedule->priority ?? 'medium',

                'problem_description' =>
                    'Auto Generate dari PM Schedule: ' . $schedule->schedule_name .
                    "\n\nSchedule No: " . $schedule->schedule_no .
                    "\n\n" . ($schedule->description ?? '-'),

                'requested_by' => $schedule->created_by,
                'assigned_to' => $schedule->assigned_to,

                'status' => 'draft',

                'planned_start_date' => $schedule->next_execution_date,
                'planned_finish_date' => $schedule->next_execution_date,

                'estimated_cost' => $schedule->estimated_cost ?? 0,
                'vendor_name' => $schedule->vendor_name,

                'notes' => 'Generated automatically from schedule: ' . $schedule->schedule_no,

                'created_by' => $schedule->created_by,
                'updated_by' => $schedule->updated_by,
            ]);

            $schedule->update([
                'last_work_order_id' => $workOrder->id,
                'updated_by' => $schedule->updated_by,
            ]);

            $schedule->asset?->logActivity(
                activityType: 'auto_generate_work_order',
                title: 'Auto Generate Work Order',
                description: 'WO ' . $workOrder->work_order_no . ' otomatis dibuat dari schedule ' . $schedule->schedule_no,
                userId: $schedule->created_by,
                referenceType: AssetWorkOrder::class,
                referenceId: $workOrder->id
            );

            $this->info('Generated WO: ' . $workOrder->work_order_no);
        }

        $this->info('Auto generate Work Order selesai.');

        return self::SUCCESS;
    }

    private function generateWorkOrderNo(): string
    {
        $date = now()->format('Ymd');
        $count = AssetWorkOrder::whereDate('created_at', now())->count() + 1;

        return 'WO-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}