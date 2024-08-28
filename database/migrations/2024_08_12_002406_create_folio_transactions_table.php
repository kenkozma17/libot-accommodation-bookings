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
        Schema::create('folio_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folio_id')->constrained()->cascadeOnDelete();
            $table->string('service_name');
            $table->integer('quantity');
            $table->string('unit')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->string('type')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->text('description')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folio_transactions');
    }
};
