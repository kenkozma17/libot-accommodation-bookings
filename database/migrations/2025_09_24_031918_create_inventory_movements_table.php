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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // increase, decrease, adjustment
            $table->decimal('quantity', 8, 2);
            $table->string('unit');
            $table->decimal('previous_stock', 8, 2);
            $table->decimal('current_stock', 8, 2);
            $table->string('note')->nullable();

            $table->unsignedBigInteger('inventory_item_id');
            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('inventory_items')
                ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('folio_transactions', function (Blueprint $table) {
            $table->dropForeign(['inventory_item_id']);
        });
        Schema::dropIfExists('inventory_movements');
    }
};
