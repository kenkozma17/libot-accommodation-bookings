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
        Schema::create('room_unavailabilities', function (Blueprint $table) {
          $table->id();
          $table->foreignId('room_id')->constrained();
          $table->foreignId('booking_id')->nullable()->constrained();
          $table->datetime('start_date');
          $table->datetime('end_date')->nullable();
          $table->boolean('is_range')->default(0);
          $table->text('notes')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_unavailabilities');
    }
};
