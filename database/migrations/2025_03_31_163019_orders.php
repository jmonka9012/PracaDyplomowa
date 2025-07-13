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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('event_id')->nullable();
            $table->decimal('total_price', 8,2)->comment('PLN');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->default('Poland');
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->enum('payment_status', ['pending', 'cancelled', 'paid'])->default('pending');
            $table->timestamps();
            $table->dateTime('last_interaction_time')->nullable();

            $table->foreign('event_id')
                 ->references('id')
                 ->on('events');

            $table->foreign('user_id')
                 ->references('id')
                 ->on('users');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
