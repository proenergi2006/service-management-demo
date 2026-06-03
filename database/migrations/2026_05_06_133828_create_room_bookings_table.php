<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 100)->unique();

            $table->foreignId('room_id')->constrained('master_rooms')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('requester_name', 150)->nullable();
            $table->string('requester_email', 150)->nullable();
            $table->string('department', 150)->nullable();

            $table->string('title', 200);
            $table->text('purpose')->nullable();

            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->integer('participant_count')->nullable();
            $table->json('additional_facilities')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_note')->nullable();

            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();

            $table->text('notes')->nullable();

            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamps();

            $table->index(['room_id', 'booking_date']);
            $table->index(['status', 'booking_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};