<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert(
            [
                [
                    'user_id'                       => 1,
                    'email'                         => 'admin@admin.com',
                    'username'                      => 'admin',
                    'password'                      => Hash::make('admin1234'),
                    'user_full_name'                => 'Admin',
                    'user_type'                     => 1,
                    'user_active_date'              => Carbon::now()->format('Y-m-d'),
                ],
            ]
        );

        User::factory()
        ->count(10)
        ->create();
    }
}
