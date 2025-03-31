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
        Schema::create('event_standing_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('hall_section_id');
            $table->decimal('price', 5,2)->comment('PLN');
            $table->integer('capacity');
            $table->integer('sold')->default(0);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('hall_section_id')->references('id')->on('hall_sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_standing_tickets');
    }
};
