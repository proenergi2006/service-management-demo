<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_checklist_templates', function (Blueprint $table) {
            $table->id();

            $table->string('template_code')->unique();
            $table->string('template_name');

            $table->enum('asset_type', [
                'general',
                'it_device',
                'network_device',
                'office_equipment',
                'office_vehicle',
                'ga_facility',
                'building_equipment',
                'truck_tank',
                'forklift',
                'fleet_vehicle',
                'genset',
            ])->default('general');

            $table->enum('maintenance_type', [
                'preventive',
                'corrective',
                'inspection',
                'calibration',
                'breakdown',
                'service',
            ])->default('preventive');

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('asset_type');
            $table->index('maintenance_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_checklist_templates');
    }
};