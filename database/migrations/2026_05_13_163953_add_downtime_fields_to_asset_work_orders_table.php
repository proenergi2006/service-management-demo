<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_work_orders', function (Blueprint $table) {
            $table->timestamp('breakdown_at')->nullable()->after('actual_finish_date');
            $table->timestamp('repair_started_at')->nullable()->after('breakdown_at');
            $table->timestamp('repair_finished_at')->nullable()->after('repair_started_at');

            $table->integer('repair_duration_minutes')->default(0)->after('repair_finished_at');
            $table->integer('downtime_minutes')->default(0)->after('repair_duration_minutes');

            $table->text('downtime_notes')->nullable()->after('downtime_minutes');
        });
    }

    public function down(): void
    {
        Schema::table('asset_work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'breakdown_at',
                'repair_started_at',
                'repair_finished_at',
                'repair_duration_minutes',
                'downtime_minutes',
                'downtime_notes',
            ]);
        });
    }
};