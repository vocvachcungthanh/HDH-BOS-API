<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Block')->insert([
            [
                'name'          => "Khối lãnh đạo",
                'note'          => "Khối lãnh đạo",
                'created_at'    => now()
            ],

            [
                'name'          => "Khối kinh doanh",
                'note'          => "Khối kinh doanh",
                'created_at'    => now()
            ],

            [
                'name'          => "Khối backoffice",
                'note'          => "Khối backoffice",
                'created_at'    => now()
            ],

            [
                'name'          => "Khối sản xuất cung ứng",
                'note'          => "Khối sản xuất cung ứng",
                'created_at'    => now()
            ]
        ]);
    }
}
