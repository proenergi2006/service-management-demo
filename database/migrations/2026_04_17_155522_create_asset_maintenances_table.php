<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('ticket_id')
                ->nullable()
                ->constrained('tickets')
                ->nullOnDelete();

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('maintenance_no', 100)->unique();
            $table->string('maintenance_type', 50)->default('corrective');
            // preventive, corrective, repair

            $table->date('request_date')->nullable();
            $table->date('schedule_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();

            $table->string('status', 50)->default('open');
            // open, scheduled, on_progress, done, cancelled

            $table->decimal('cost', 18, 2)->nullable();

            $table->text('issue_description')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('result_notes')->nullable();

            $table->timestamps();

            $table->index(['asset_id', 'status']);
            $table->index(['ticket_id']);
            $table->index(['maintenance_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
    }
};