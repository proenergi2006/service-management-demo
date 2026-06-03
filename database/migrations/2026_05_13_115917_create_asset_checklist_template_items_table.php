<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_checklist_template_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')
                ->constrained('asset_checklist_templates')
                ->cascadeOnDelete();

            $table->integer('sort_order')->default(1);

            $table->string('item_name');
            $table->text('item_description')->nullable();

            $table->enum('input_type', [
                'check',
                'text',
                'number',
                'yes_no',
                'condition',
            ])->default('check');

            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('template_id');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_checklist_template_items');
    }
};