<?php

return [
    'admins' => [
        [
            'name' => 'JKrzeski',
            'email' => env('ADMIN1_EMAIL'),
            'password' => '12341234',
            'role' => 'admin', 
            'first_name' => "Jedrzej",
            'last_name' => "Krzeski",
        ],
        [
            'name' => 'JMonka',
            'email' => env('ADMIN2_EMAIL'),
            'password' => '12341234',
            'role' => 'admin',
            'first_name' => "Jacek",
            'last_name' => "Monka",
        ],
        [
            'name' => 'MBorkowski',
            'email' => env('ADMIN3_EMAIL'),
            'password' => '12341234',
            'role' => 'admin',
            'first_name' => "Mateusz",
            'last_name' => "Borkowski",
        ],
        [
            'name' => 'PGalimski',
            'email' => env('ADMIN4_EMAIL'),
            'password' => '12341234',
            'role' => 'admin',
            'first_name' => "Piotr",
            'last_name' => "Galimski", 
        ],
    ],
];
