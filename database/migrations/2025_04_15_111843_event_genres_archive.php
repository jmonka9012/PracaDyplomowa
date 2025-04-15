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
        Schema::create('event_genres_archive', function (Blueprint $table) 
        {
            $table->id();
            
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('genre_id');

            $table->foreign('event_id')->references('id')->on('events_archive')->cascadeOnDelete();
            $table->foreign('genre_id')->references('id')->on('genres')->cascadeOnDelete();

            $table->unique(['event_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_genres_archive');
    }
};
