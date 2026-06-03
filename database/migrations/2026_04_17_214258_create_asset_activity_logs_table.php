<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_activity_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('activity_type', 100);
            // created, updated, assigned, returned, maintenance_created, document_uploaded, document_deleted

            $table->string('title', 150);
            $table->text('description')->nullable();

            $table->string('reference_type', 100)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['asset_id', 'activity_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_activity_logs');
    }
};