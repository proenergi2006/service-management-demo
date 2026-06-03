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
        Schema::create('asset_sparepart_movements', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('sparepart_id')
                ->constrained('asset_spareparts')
                ->cascadeOnDelete();
        
            $table->enum('movement_type', [
                'stock_in',
                'stock_out',
                'adjustment',
                'usage_wo',
            ]);
        
            $table->decimal('qty', 15, 2);
            $table->decimal('stock_before', 15, 2)->default(0);
            $table->decimal('stock_after', 15, 2)->default(0);
        
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
        
            $table->date('movement_date');
            $table->text('notes')->nullable();
        
            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();
        
            $table->timestamps();
        
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_sparepart_movements');
    }
};
