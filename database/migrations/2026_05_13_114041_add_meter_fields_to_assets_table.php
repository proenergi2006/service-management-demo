<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            $table->enum('meter_type', [
                'none',
                'km',
                'hour_meter',
                'runtime',
            ])->default('none');

            $table->decimal('current_meter', 15, 2)
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {

            $table->dropColumn([
                'meter_type',
                'current_meter',
            ]);
        });
    }
};