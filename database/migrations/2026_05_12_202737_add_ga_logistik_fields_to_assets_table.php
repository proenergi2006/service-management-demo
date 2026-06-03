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
        Schema::table('assets', function (Blueprint $table) {
            // Fleet / Logistik
            $table->string('plate_number')->nullable()->after('serial_number');
            $table->string('engine_number')->nullable()->after('plate_number');
            $table->string('chassis_number')->nullable()->after('engine_number');
            $table->decimal('capacity', 12, 2)->nullable()->after('chassis_number');
            $table->string('capacity_unit')->nullable()->after('capacity'); // Liter, KL, Ton, Seat
    
            $table->date('stnk_expired_date')->nullable()->after('warranty_end_date');
            $table->date('kir_expired_date')->nullable()->after('stnk_expired_date');
            $table->date('insurance_expired_date')->nullable()->after('kir_expired_date');
    
            $table->string('fuel_type')->nullable()->after('insurance_expired_date');
            $table->integer('odometer')->nullable()->after('fuel_type');
            $table->integer('service_interval_km')->nullable()->after('odometer');
            $table->date('last_service_date')->nullable()->after('service_interval_km');
            $table->date('next_service_date')->nullable()->after('last_service_date');
    
            // GA / Facility
            $table->string('facility_area')->nullable()->after('next_service_date'); // Lobby, Meeting Room, Warehouse
            $table->string('floor')->nullable()->after('facility_area');
            $table->string('room_name')->nullable()->after('floor');
    
            // Extra classification
            $table->string('asset_type')->nullable()->after('owner_role'); 
            // contoh: it_device, ga_facility, fleet_vehicle, truck_tank, forklift
        });
    }
    
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'plate_number',
                'engine_number',
                'chassis_number',
                'capacity',
                'capacity_unit',
                'stnk_expired_date',
                'kir_expired_date',
                'insurance_expired_date',
                'fuel_type',
                'odometer',
                'service_interval_km',
                'last_service_date',
                'next_service_date',
                'facility_area',
                'floor',
                'room_name',
                'asset_type',
            ]);
        });
    }

   
};
