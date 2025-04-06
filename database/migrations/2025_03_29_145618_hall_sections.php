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

        $hall = Hall::create([
            'hall_name' => 'Ziggy Zone',
            'hall_price'=> 500,
            'hall_height'=> '2',
            'hall_width'=> '3',
        ]);
        $hall->sections()->createMany([
            [
                'section_name' => 'Hala 1',
                'section_type' => 'seat',
                'row' => 6,
                'col' => 10,
                'section_height' => '1',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Hala 2',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '1',
                'section_width' => '2',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Hala 3',
                'section_type' => 'seat',
                'row' => 6,
                'col' => 10,
                'section_height' => '1',
                'section_width' => '3'
            ],
            [
                'section_name' => 'Hala 4',
                'section_type' => 'seat',
                'row' => 3,
                'col' => 10,
                'section_height' => '2',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Hala 5',
                'section_type' => 'seat',
                'row' => 6,
                'col' => 10,
                'section_height' => '2',
                'section_width' => '2'
            ],
            [
                'section_name' => 'Hala 6',
                'section_type' => 'seat',
                'row' => 3,
                'col' => 10,
                'section_height' => '2',
                'section_width' => '3'
            ],
        ]);

        $hall = Hall::create([
            'hall_name' => 'Trvth Hall',
            'hall_price'=> 5000,
            'hall_height'=> '2',
            'hall_width'=> '2',
        ]);
        $hall->sections()->createMany([
            [
                'section_name' => 'Halla 1',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'capacity' => '150',
                'section_height' => '1',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Halla 2',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'capacity' => '150',
                'section_height' => '1',
                'section_width' => '2'
            ],
            [
                'section_name' => 'Hala 3',
                'section_type' => 'seat',
                'row' => 10,
                'col' => 5,
                'capacity' => 150,
                'section_height' => '2',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Hala 4',
                'section_type' => 'seat',
                'row' => 10,
                'col' => 5,
                'capacity' => 300,
                'section_height' => '2',
                'section_width' => '2'
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
