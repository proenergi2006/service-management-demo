<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_maintenance_vendors', function (Blueprint $table) {
            $table->id();

            $table->string('vendor_code')->unique();
            $table->string('vendor_name');
            $table->string('vendor_type')->nullable(); // AC, Truck, IT, Genset, Kalibrasi

            $table->string('pic_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->text('address')->nullable();
            $table->text('service_scope')->nullable();

            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('vendor_name');
            $table->index('vendor_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenance_vendors');
    }
};