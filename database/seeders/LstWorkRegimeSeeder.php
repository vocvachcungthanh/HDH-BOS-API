<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LstWorkRegimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Work_Regime')->insert([
            [
                'name'          => 'Làm đến hết thứ 6',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'Làm đến hết thứ T6 + nửa ngày T7',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'Làm đến hết thứ T6 + thứ 7 cách tuần',

                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'Làm đến hết ngày thứ 7',
                'created_at'    => now(),
                'updated_at'    => now()
            ]
        ]);
    }
}
