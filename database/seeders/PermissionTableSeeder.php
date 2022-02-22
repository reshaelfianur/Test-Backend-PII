<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('permissions')->insert([
            [
                'id'            => 1,
                'name'          => 'user-create',
                'display_name'  => 'User Create',
                'description'   => 'Create new User',
                'type'          => 1,
                'submod_id'     => 1,
            ],
            [
                'id'            => 2,
                'name'          => 'user-read',
                'display_name'  => 'User Read',
                'description'   => 'Read User data',
                'type'          => 2,
                'submod_id'     => 1,
            ],
            [
                'id'            => 3,
                'name'          => 'user-not-allowed',
                'display_name'  => 'User Not Allowed',
                'description'   => 'Can not allow access User',
                'type'          => 3,
                'submod_id'     => 1,
            ],
            [
                'id'            => 4,
                'name'          => 'employee-create',
                'display_name'  => 'Employee Create',
                'description'   => 'Create new Employee',
                'type'          => 1,
                'submod_id'     => 2,
            ],
            [
                'id'            => 5,
                'name'          => 'employee-read',
                'display_name'  => 'Employee Read',
                'description'   => 'Read Employee data',
                'type'          => 2,
                'submod_id'     => 2,
            ],
            [
                'id'            => 6,
                'name'          => 'employee-not-allowed',
                'display_name'  => 'Employee Not Allowed',
                'description'   => 'Can not allow access Employee',
                'type'          => 3,
                'submod_id'     => 2,
            ],
            [
                'id'            => 7,
                'name'          => 'room-create',
                'display_name'  => 'Room Create',
                'description'   => 'Create new Room',
                'type'          => 1,
                'submod_id'     => 3,
            ],
            [
                'id'            => 8,
                'name'          => 'room-read',
                'display_name'  => 'Room Read',
                'description'   => 'Read Room data',
                'type'          => 2,
                'submod_id'     => 3,
            ],
            [
                'id'            => 9,
                'name'          => 'room-not-allowed',
                'display_name'  => 'Room Not Allowed',
                'description'   => 'Can not allow access Room',
                'type'          => 3,
                'submod_id'     => 3,
            ],
            [
                'id'            => 10,
                'name'          => 'facility-create',
                'display_name'  => 'Facility Create',
                'description'   => 'Create new Facility',
                'type'          => 1,
                'submod_id'     => 3,
            ],
            [
                'id'            => 11,
                'name'          => 'facility-read',
                'display_name'  => 'Facility Read',
                'description'   => 'Read Facility data',
                'type'          => 2,
                'submod_id'     => 3,
            ],
            [
                'id'            => 12,
                'name'          => 'facility-not-allowed',
                'display_name'  => 'Facility Not Allowed',
                'description'   => 'Can not allow access Facility',
                'type'          => 3,
                'submod_id'     => 3,
            ],
            [
                'id'            => 13,
                'name'          => 'work-meeting-create',
                'display_name'  => 'Work Meeting Create',
                'description'   => 'Create new Work Meeting',
                'type'          => 1,
                'submod_id'     => 4,
            ],
            [
                'id'            => 14,
                'name'          => 'work-meeting-read',
                'display_name'  => 'Work Meeting Read',
                'description'   => 'Read Work Meeting data',
                'type'          => 2,
                'submod_id'     => 4,
            ],
            [
                'id'            => 15,
                'name'          => 'work-meeting-not-allowed',
                'display_name'  => 'Work Meeting Not Allowed',
                'description'   => 'Can not allow access Work Meeting',
                'type'          => 3,
                'submod_id'     => 4,
            ],
            [
                'id'            => 16,
                'name'          => 'work-meeting-participant-create',
                'display_name'  => 'Work Meeting Participant Create',
                'description'   => 'Create new Work Meeting Participant',
                'type'          => 1,
                'submod_id'     => 4,
            ],
            [
                'id'            => 17,
                'name'          => 'work-meeting-participant-read',
                'display_name'  => 'Work Meeting Participant Read',
                'description'   => 'Read Work Meeting Participant data',
                'type'          => 2,
                'submod_id'     => 4,
            ],
            [
                'id'            => 18,
                'name'          => 'work-meeting-participant-not-allowed',
                'display_name'  => 'Work Meeting Participant Not Allowed',
                'description'   => 'Can not allow access Work Meeting Participant',
                'type'          => 3,
                'submod_id'     => 4,
            ],
            [
                'id'            => 19,
                'name'          => 'minutes-of-meeting-create',
                'display_name'  => 'Minutes Of Meeting Create',
                'description'   => 'Create new Minutes Of Meeting',
                'type'          => 1,
                'submod_id'     => 4,
            ],
            [
                'id'            => 20,
                'name'          => 'minutes-of-meeting-read',
                'display_name'  => 'Minutes Of Meeting Read',
                'description'   => 'Read Minutes Of Meeting data',
                'type'          => 2,
                'submod_id'     => 4,
            ],
            [
                'id'            => 21,
                'name'          => 'minutes-of-meeting-not-allowed',
                'display_name'  => 'Minutes Of Meeting Not Allowed',
                'description'   => 'Can not allow access Minutes Of Meeting',
                'type'          => 3,
                'submod_id'     => 4,
            ],
        ]);
    }
}
