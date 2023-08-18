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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_confirmation')->unique();
            $table->datetime('check_in');
            $table->datetime('check_out');
            $table->decimal('rate_per_night', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->string('booking_status');
            $table->text('special_requests')->nullable();
            $table->unsignedInteger('adults_count')->default(0);
            $table->unsignedInteger('children_count')->default(0);

            $table->foreignId('guest_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('payment_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
