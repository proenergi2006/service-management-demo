<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_code', 50)->unique();
            $table->string('plate_number', 50)->unique();

            $table->string('vehicle_name', 150)->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('capacity')->default(0);

            $table->string('ownership_status', 50)->default('company');
            $table->string('branch', 150)->nullable();
            $table->string('location', 150)->nullable();

            $table->enum('vehicle_status', [
                'available',
                'booked',
                'on_trip',
                'maintenance',
                'inactive',
            ])->default('available');

            $table->date('stnk_expired_date')->nullable();
            $table->date('kir_expired_date')->nullable();
            $table->date('insurance_expired_date')->nullable();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index(['vehicle_status', 'is_active']);
            $table->index(['branch', 'location']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_vehicles');
    }
};