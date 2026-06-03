<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_work_orders', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | WORK ORDER INFO
            |--------------------------------------------------------------------------
            */

            $table->string('work_order_no')->unique();

            $table->enum('maintenance_type', [
                'preventive',
                'corrective',
                'inspection',
                'calibration',
                'breakdown',
            ])->default('corrective');

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            $table->text('problem_description');

            $table->text('root_cause')->nullable();

            $table->text('repair_action')->nullable();

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'submitted',
                'approved',
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
                'rejected',
            ])->default('draft');

            /*
            |--------------------------------------------------------------------------
            | APPROVAL
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('approval_note')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SCHEDULE
            |--------------------------------------------------------------------------
            */

            $table->dateTime('planned_start_date')->nullable();

            $table->dateTime('planned_finish_date')->nullable();

            $table->dateTime('actual_start_date')->nullable();

            $table->dateTime('actual_finish_date')->nullable();

            /*
            |--------------------------------------------------------------------------
            | COST
            |--------------------------------------------------------------------------
            */

            $table->decimal('estimated_cost', 18, 2)
                ->default(0);

            $table->decimal('actual_cost', 18, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | VENDOR
            |--------------------------------------------------------------------------
            */

            $table->string('vendor_name')->nullable();

            $table->string('vendor_pic')->nullable();

            $table->string('vendor_phone')->nullable();

            /*
            |--------------------------------------------------------------------------
            | METER / ODOMETER
            |--------------------------------------------------------------------------
            */

            $table->bigInteger('start_meter')->nullable();

            $table->bigInteger('end_meter')->nullable();

            /*
            |--------------------------------------------------------------------------
            | DOCUMENT
            |--------------------------------------------------------------------------
            */

            $table->string('attachment')->nullable();

            $table->text('notes')->nullable();

            /*
            |--------------------------------------------------------------------------
            | AUDIT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('status');
            $table->index('maintenance_type');
            $table->index('priority');
            $table->index('planned_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_work_orders');
    }
};