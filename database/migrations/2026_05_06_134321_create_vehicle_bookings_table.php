<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 100)->unique();

            $table->foreignId('vehicle_id')->nullable()->constrained('master_vehicles')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('requester_name', 150)->nullable();
            $table->string('requester_email', 150)->nullable();
            $table->string('department', 150)->nullable();
            $table->string('branch', 150)->nullable();

            $table->string('destination', 255);
            $table->text('purpose')->nullable();

            $table->enum('driver_source', [
                'internal',
                'vendor',
                'self_drive',
            ])->default('self_drive');

            $table->string('driver_name', 150)->nullable();
            $table->string('driver_phone', 50)->nullable();

            $table->timestamp('departure_datetime');
            $table->timestamp('return_datetime')->nullable();

            $table->integer('passenger_count')->nullable();
            $table->text('passenger_names')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'on_trip',
                'returned',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_note')->nullable();

            $table->timestamp('actual_departure_at')->nullable();
            $table->timestamp('actual_return_at')->nullable();

            $table->integer('start_odometer')->nullable();
            $table->integer('end_odometer')->nullable();

            $table->decimal('fuel_cost', 18, 2)->nullable();
            $table->decimal('parking_cost', 18, 2)->nullable();
            $table->decimal('toll_cost', 18, 2)->nullable();
            $table->decimal('other_cost', 18, 2)->nullable();

            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();

            $table->text('notes')->nullable();

            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index(['vehicle_id', 'departure_datetime']);
            $table->index(['status', 'departure_datetime']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_bookings');
    }
};