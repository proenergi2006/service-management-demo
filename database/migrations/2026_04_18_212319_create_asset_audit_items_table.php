<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_audit_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_audit_id')->constrained('asset_audits')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();

            $table->string('audit_result', 50)->default('found');
            // found, not_found, damaged

            $table->string('actual_location', 150)->nullable();
            $table->string('actual_holder_name', 150)->nullable();

            $table->text('notes')->nullable();
            $table->timestamp('scanned_at')->nullable();

            $table->foreignId('scanned_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['asset_audit_id', 'asset_id']);
            $table->index(['asset_audit_id', 'audit_result']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_audit_items');
    }
};