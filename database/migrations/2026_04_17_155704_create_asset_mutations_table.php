<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_mutations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('from_location_id')
                ->nullable()
                ->constrained('asset_locations')
                ->nullOnDelete();

            $table->foreignId('to_location_id')
                ->nullable()
                ->constrained('asset_locations')
                ->nullOnDelete();

            $table->foreignId('from_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('to_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('mutation_type', 50);
            // transfer_location, handover_user, repair_send, repair_return, disposal

            $table->date('mutation_date');
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index(['asset_id', 'mutation_type']);
            $table->index(['mutation_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_mutations');
    }
};