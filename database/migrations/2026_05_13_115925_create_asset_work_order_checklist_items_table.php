<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_work_order_checklist_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('work_order_id')
                ->constrained('asset_work_orders')
                ->cascadeOnDelete();

            $table->foreignId('template_item_id')
                ->nullable()
                ->constrained('asset_checklist_template_items')
                ->nullOnDelete();

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

            $table->string('result_value')->nullable();
            $table->text('result_notes')->nullable();

            $table->boolean('is_done')->default(false);

            $table->foreignId('checked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('checked_at')->nullable();

            $table->timestamps();

            $table->index('work_order_id');
            $table->index('is_done');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_work_order_checklist_items');
    }
};