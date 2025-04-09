<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hall;
use App\Models\HallSection;


class StaticHallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
}
