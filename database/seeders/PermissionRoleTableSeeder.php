<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permission_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('permission_role')->insert([
            [
                'permission_id'     => 1,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 4,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 7,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 10,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 13,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 16,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 19,
                'role_id'           => 1,
            ],
            [
                'permission_id'     => 3,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 6,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 9,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 12,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 13,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 16,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 19,
                'role_id'           => 2,
            ],
            [
                'permission_id'     => 3,
                'role_id'           => 3,
            ],
            [
                'permission_id'     => 6,
                'role_id'           => 3,
            ],
            [
                'permission_id'     => 9,
                'role_id'           => 3,
            ],
            [
                'permission_id'     => 12,
                'role_id'           => 3,
            ],
            [
                'permission_id'     => 15,
                'role_id'           => 3,
            ],
            [
                'permission_id'     => 16,
                'role_id'           => 3,
            ],
            [
                'permission_id'     => 19,
                'role_id'           => 3,
            ],
        ]);
    }
}
