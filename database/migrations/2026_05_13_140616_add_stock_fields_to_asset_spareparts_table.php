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
        Schema::table('asset_spareparts', function (Blueprint $table) {
            $table->decimal('current_stock', 15, 2)->default(0)->after('unit');
            $table->decimal('minimum_stock', 15, 2)->default(0)->after('current_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_spareparts', function (Blueprint $table) {
            //
        });
    }
};
