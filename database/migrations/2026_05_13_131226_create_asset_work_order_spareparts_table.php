<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_work_order_spareparts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('work_order_id')
                ->constrained('asset_work_orders')
                ->cascadeOnDelete();

            $table->foreignId('sparepart_id')
                ->nullable()
                ->constrained('asset_spareparts')
                ->nullOnDelete();

            $table->string('sparepart_name');

            $table->string('unit')->default('pcs');

            $table->decimal('qty', 15, 2)->default(1);
            $table->decimal('unit_price', 18, 2)->default(0);
            $table->decimal('total_price', 18, 2)->default(0);

            $table->string('vendor_name')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('work_order_id');
            $table->index('sparepart_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_work_order_spareparts');
    }
};