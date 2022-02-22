<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('facilities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('facilities')->insert(
            [
                [
                    'facility_name'             => 'Laptop',
                    'facility_description'      => 'Laptop untuk peserta',
                ],
                [
                    'facility_name'             => 'Proyektor',
                    'facility_description'      => 'Proyektor untuk presenter',
                ],
                [
                    'facility_name'             => 'Snack',
                    'facility_description'      => 'Cemilan untuk peserta',
                ],
                [
                    'facility_name'             => 'AC',
                    'facility_description'      => 'AC untuk penyejuk ruangan',
                ],
                [
                    'facility_name'             => 'Kipas Angin',
                    'facility_description'      => 'Kipas Angin untuk penyejuk ruangan',
                ],
            ]
        );
    }
}
