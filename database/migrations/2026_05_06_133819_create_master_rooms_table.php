<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_code', 50)->unique();
            $table->string('room_name', 150);
            $table->string('location', 150)->nullable();
            $table->string('floor', 50)->nullable();
            $table->integer('capacity')->default(0);
            $table->json('facilities')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index(['room_name', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_rooms');
    }
};