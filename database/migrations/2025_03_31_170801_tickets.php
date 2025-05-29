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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable(); // na razie nullabe. trzeba stworzyc logike do faktur
            $table->unsignedBigInteger('event_id');
            $table->boolean('is_guest')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('insured')->default(false);
            $table->boolean('is_seat');
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->unsignedBigInteger('standing_id')->nullable();
            $table->decimal('price', 5,2)->comment('PLN')->nullable();
            $table->enum('payment_status', ['unpaid','paid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('event_id')
                 ->references('id')
                 ->on('events');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('seat_id')
                ->references('id')
                ->on('event_seats');

            $table->foreign('standing_id')
                ->references('id')
                ->on('event_standing_tickets');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
