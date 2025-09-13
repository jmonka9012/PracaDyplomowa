<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrganizerAccountStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organizer_information', function (Blueprint $table) 
        {
            $table->id();            
            $table->unsignedBigInteger('user_id');
            $table->string('company_name');
            $table->string('phone_number');
            $table->string('tax_number');
            $table->string('address_country');
            $table->string('address_zip_code');
            $table->string('address_city');
            $table->string('address_street');
            $table->string('bank_account_number');
            
            $table->enum('account_status', OrganizerAccountStatus::values())
                ->default(OrganizerAccountStatus::PENDING->value);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizer_information');
    }
};
