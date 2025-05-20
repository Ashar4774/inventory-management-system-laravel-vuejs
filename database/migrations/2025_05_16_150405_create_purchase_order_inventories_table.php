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
        Schema::create('purchase_order_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
            $table->integer('unit_price');
            $table->integer('quantity_ordered');
            $table->integer('quantity_received')->nullable();
            $table->integer('discount')->nullable();
            $table->enum('discount_type', ['amount', 'percent'])->nullable();
            $table->integer('total_price');
            $table->enum('status', ['pending', 'received', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_inventories');
    }
};
