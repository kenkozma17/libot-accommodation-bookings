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
        Schema::create('event_event_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'event_id');
            $table->unsignedBigInteger(column: 'event_set_id');
            $table->foreign('event_id')->references('id')->on('events')->constrained();
            $table->foreign('event_set_id')->references('id')->on('event_sets')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_event_sets');
    }
};
