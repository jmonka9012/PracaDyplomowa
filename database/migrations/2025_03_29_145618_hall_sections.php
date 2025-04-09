<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Hall;
use App\Models\HallSection;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hall_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id');
            $table->string('section_name');
            $table->enum('section_type', ['seat','stand'])->default('stand');
            $table->integer('col')->nullable();
            $table->integer('row')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('section_height')->nullable();
            $table->integer('section_width')->nullable();

            $table->foreign('hall_id')
                ->references('id')->on('halls');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_sections');
    }
};
