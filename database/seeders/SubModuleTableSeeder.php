<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sub_modules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('sub_modules')->insert([
            [
                'submod_id'     => 1,
                'mod_id'        => 1,
                'submod_code'   => 'user',
                'submod_name'   => 'User',
            ],
            [
                'submod_id'     => 2,
                'mod_id'        => 2,
                'submod_code'   => 'employee',
                'submod_name'   => 'Employee',
            ],
            [
                'submod_id'     => 3,
                'mod_id'        => 3,
                'submod_code'   => 'room',
                'submod_name'   => 'Room',
            ],
            [
                'submod_id'     => 4,
                'mod_id'        => 3,
                'submod_code'   => 'facility',
                'submod_name'   => 'Facility',
            ],
            [
                'submod_id'     => 5,
                'mod_id'        => 4,
                'submod_code'   => 'work-meeting',
                'submod_name'   => 'Work Meeting',
            ],
            [
                'submod_id'     => 6,
                'mod_id'        => 4,
                'submod_code'   => 'work-meeting-participant',
                'submod_name'   => 'Work Meeting Participant',
            ],
            [
                'submod_id'     => 7,
                'mod_id'        => 4,
                'submod_code'   => 'minutes-of-meeting',
                'submod_name'   => 'Minutes Of Meeting',
            ],
        ]);
    }
}
