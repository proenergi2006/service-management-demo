<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_spareparts', function (Blueprint $table) {
            $table->id();

            $table->string('sparepart_code')->unique();
            $table->string('sparepart_name');

            $table->string('category')->nullable();
            $table->string('unit')->default('pcs');

            $table->decimal('standard_price', 18, 2)->default(0);

            $table->string('vendor_name')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('sparepart_code');
            $table->index('sparepart_name');
            $table->index('category');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_spareparts');
    }
};