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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('payment_amount', 10, 2);
            $table->string('payment_status');
            $table->datetime('payment_date');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->string('payer_name');
            $table->string('payer_email');
            $table->string('card_last_four_digits')->nullable();
            $table->string('card_expiry_date')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('additional_details')->nullable();

            $table->string('payment_gateway')->nullable();
            $table->string('receipt_number')->nullable(); 
            $table->string('payment_reference')->nullable();
            $table->string('currency_code')->nullable(); 
            $table->string('payment_source')->nullable();

            // $table->foreignId('booking_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
