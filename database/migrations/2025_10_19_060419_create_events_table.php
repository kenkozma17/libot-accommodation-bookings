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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('pax')->default(1);
            $table->time('setup_time');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('serving_time');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable();
            $table->string('status')->default('CONFIRMED');

            $table->unsignedBigInteger('guest_id');
            $table->foreign('guest_id')
              ->references('id')
              ->on('guests')
              ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
           $table->dropForeign(['guest_id']);
            $table->dropColumn('guest_id');
        });
        Schema::dropIfExists('events');
    }
};
