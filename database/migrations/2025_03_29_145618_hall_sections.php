<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Halls;
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
            $table->integer('capacity');

            $table->foreign('hall_id')
                ->references('id')->on('halls');
        });

        $hall = Halls::create([
            'hall_name' => 'Ziggy Zone',
            'seat_capacity' => 300,
            'stand_capacity' => 100,
            'hall_price'=> 500,
        ]);
        $hall->sections()->createMany([
            [
                'section_name' => 'A',
                'section_type' => 'seat',
                'row' => 10,
                'col' => 20,
                'capacity' => 200
            ],
            [
                'section_name' => 'B',
                'section_type' => 'seat',
                'row' => 5,
                'col' => 20,
                'capacity' => 100
            ],
            [
                'section_name' => 'C',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'capacity' => 100
            ]
        ]);

    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_sections');
    }
};
