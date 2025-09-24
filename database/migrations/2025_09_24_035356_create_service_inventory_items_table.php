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
        Schema::create('service_inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'service_id');
            $table->unsignedBigInteger(column: 'inventory_item_id');
            $table->foreign('service_id')->references('id')->on('services')->constrained();
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->constrained();

            $table->decimal('quantity', 2);
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
          $table->dropForeign(['service_id', 'inventory_item_id']);
        });
        Schema::dropIfExists('service_inventory_items');
    }
};
