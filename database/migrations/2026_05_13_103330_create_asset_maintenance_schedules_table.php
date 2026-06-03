<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_maintenance_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->string('schedule_no')->unique();

            $table->enum('maintenance_type', [
                'preventive',
                'inspection',
                'calibration',
                'service',
            ])->default('preventive');

            $table->string('schedule_name');

            $table->text('description')->nullable();

            $table->enum('frequency_type', [
                'daily',
                'weekly',
                'monthly',
                'yearly',
                'km',
                'hour_meter',
            ])->default('monthly');

            $table->integer('frequency_interval')->default(1);

            $table->date('start_date')->nullable();
            $table->date('last_execution_date')->nullable();
            $table->date('next_execution_date')->nullable();

            $table->bigInteger('last_meter')->nullable();
            $table->bigInteger('next_meter')->nullable();

            $table->integer('reminder_days_before')->default(7);

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('medium');

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('vendor_name')->nullable();
            $table->decimal('estimated_cost', 18, 2)->default(0);

            $table->boolean('auto_generate_wo')->default(false);

            $table->foreignId('last_work_order_id')
                ->nullable()
                ->constrained('asset_work_orders')
                ->nullOnDelete();

            $table->enum('status', [
                'active',
                'inactive',
                'completed',
            ])->default('active');

            $table->text('notes')->nullable();

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

            $table->index('maintenance_type');
            $table->index('frequency_type');
            $table->index('next_execution_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenance_schedules');
    }
};