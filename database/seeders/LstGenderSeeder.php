<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LstGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Gender')->insert([
            [
                'name'          => 'Nam',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'Nữ',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'Khác',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }
}
