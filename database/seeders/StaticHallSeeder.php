<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hall;


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
                'section_name' => 'Sekcja 1',
                'section_type' => 'seat',
                'row' => 6,
                'col' => 10,
                'section_height' => '1',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Sekcja 2',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '1',
                'section_width' => '2',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 3',
                'section_type' => 'seat',
                'row' => 6,
                'col' => 10,
                'section_height' => '1',
                'section_width' => '3'
            ],
            [
                'section_name' => 'Sekcja 4',
                'section_type' => 'seat',
                'row' => 3,
                'col' => 10,
                'section_height' => '2',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Sekcja 5',
                'section_type' => 'seat',
                'row' => 6,
                'col' => 10,
                'section_height' => '2',
                'section_width' => '2'
            ],
            [
                'section_name' => 'Sekcja 6',
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
                'section_name' => 'Sekcja 1',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'capacity' => '150',
                'section_height' => '1',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Sekcja 2',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'capacity' => '150',
                'section_height' => '1',
                'section_width' => '2'
            ],
            [
                'section_name' => 'Sekcja 3',
                'section_type' => 'seat',
                'row' => 10,
                'col' => 5,
                'capacity' => 150,
                'section_height' => '2',
                'section_width' => '1'
            ],
            [
                'section_name' => 'Sekcja 4',
                'section_type' => 'seat',
                'row' => 10,
                'col' => 5,
                'capacity' => 300,
                'section_height' => '2',
                'section_width' => '2'
            ]
        ]);

        $hall = Hall::create([
            'hall_name' => 'Eddie Hall',
            'hall_price'=> 50000,
            'hall_height'=> '3',
            'hall_width'=> '3',
        ]);
        $hall->sections()->createMany([
            [
                'section_name' => 'Sekcja 1',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '1',
                'section_width' => '1',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 2',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '1',
                'section_width' => '2',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 3',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '1',
                'section_width' => '3',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 4',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '2',
                'section_width' => '1',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 5',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '2',
                'section_width' => '2',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 6',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '2',
                'section_width' => '3',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 7',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '3',
                'section_width' => '1',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 8',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '3',
                'section_width' => '2',
                'capacity' => 100,
            ],
            [
                'section_name' => 'Sekcja 9',
                'section_type' => 'stand',
                'row' => null,
                'col' => null,
                'section_height' => '3',
                'section_width' => '3',
                'capacity' => 100,
            ],
        ]);
    }

    
}
