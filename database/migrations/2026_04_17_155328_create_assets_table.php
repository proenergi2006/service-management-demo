<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->string('asset_code', 100)->unique();
            $table->string('asset_name', 200);

            $table->foreignId('category_id')
                ->constrained('asset_categories')
                ->restrictOnDelete();

            $table->foreignId('location_id')
                ->nullable()
                ->constrained('asset_locations')
                ->nullOnDelete();

            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 150)->nullable()->index();
            $table->string('qr_code', 150)->nullable()->unique();

            $table->date('purchase_date')->nullable();
            $table->date('received_date')->nullable();
            $table->date('warranty_start_date')->nullable();
            $table->date('warranty_end_date')->nullable();

            $table->string('condition_status', 50)->default('good');
            // good, fair, damaged, repair, disposed

            $table->string('lifecycle_status', 50)->default('in_stock');
            // in_stock, assigned, maintenance, disposed, lost

            $table->string('syop_pr_no', 100)->nullable()->index();
            $table->string('syop_po_no', 100)->nullable()->index();
            $table->string('accurate_asset_id', 100)->nullable()->index();

            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('asset_name');
            $table->index('condition_status');
            $table->index('lifecycle_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};