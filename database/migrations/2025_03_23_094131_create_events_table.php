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
            $table->string('event_name');
            $table->string('event_additional_url')->nullable();
            $table->string('slug')->nullable();
            $table->string('event_url')->nullable();
            $table->date('event_date');
            $table->time('event_start');
            $table->time('event_end');
            $table->string('contact_email');
            $table->string('contact_email_additional');
            $table->text('event_description');
            $table->text('event_description_additional')->nullable();
            $table->string('event_location');
            $table->string('image_path')->nullable();
            $table->boolean('pending')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
