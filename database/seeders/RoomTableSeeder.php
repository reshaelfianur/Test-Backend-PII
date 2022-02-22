<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rooms')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('rooms')->insert(
            [
                [
                    'room_name'             => 'Room #1',
                    'room_capacity'         => 5,
                    'room_description'      => 'Ruang untuk 5 orang',
                ],
                [
                    'room_name'             => 'Room #2',
                    'room_capacity'         => 10,
                    'room_description'      => 'Ruang untuk 10 orang',
                ],
                [
                    'room_name'             => 'Room #3',
                    'room_capacity'         => 20,
                    'room_description'      => 'Ruang untuk 20 orang',
                ],
                [
                    'room_name'             => 'Room #4',
                    'room_capacity'         => 40,
                    'room_description'      => 'Ruang untuk 40 orang',
                ],
                [
                    'room_name'             => 'Room #5',
                    'room_capacity'         => 80,
                    'room_description'      => 'Ruang untuk 80 orang',
                ],
            ]
        );
    }
}
