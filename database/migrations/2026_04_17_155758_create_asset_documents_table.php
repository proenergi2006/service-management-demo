<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->string('document_type', 50)->nullable();
            // invoice, photo, warranty, manual, bast, other

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_mime', 100)->nullable();
            $table->bigInteger('file_size')->nullable();

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['asset_id', 'document_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_documents');
    }
};