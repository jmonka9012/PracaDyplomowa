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
        Schema::create('tickets_archive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->boolean('is_guest')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('insured')->default(false);
            $table->dateTime('archived_at')->useCurrent();
            $table->boolean('is_seat');
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->unsignedBigInteger('standing_id')->nullable();
            $table->enum('payment_status', ['unpaid','paid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('event_id')
                 ->references('id')
                 ->on('events_archive');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('seat_id')
                ->references('id')
                ->on('event_seats_archive');

            $table->foreign('standing_id')
                ->references('id')
                ->on('event_standing_tickets_archive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_archive');
    }
};
