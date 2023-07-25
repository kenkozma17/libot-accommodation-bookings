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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('room_number');
            $table->decimal('rate', 8, 2);
            $table->text('description')->nullable();
            $table->unsignedInteger('max_occupancy')->default(1);
            $table->boolean('is_available')->default(0);
            $table->string('status')->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->unsignedInteger('size')->default(0);
            $table->unsignedInteger('floor')->default(0); 
            $table->unsignedInteger('beds')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
