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
            $table->boolean('is_guest');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->decimal('total_price', 5,2)->comment('PLN');
            $table->string('customer_number')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('country')->default('Poland');
            $table->string('zip_code');
            $table->string('city');
            $table->string('address');
            $table->string('apartment_number')->nullable();
            $table->timestamps();
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
