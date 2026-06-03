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
        Schema::create('guest_visits', function (Blueprint $table) {
            $table->id();
            $table->string('guest_code')->unique();
            $table->string('guest_name');
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('host_name')->nullable();
            $table->string('purpose')->nullable();
            $table->string('branch')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->enum('status', ['checked_in', 'checked_out'])->default('checked_in');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_visits');
    }
};
