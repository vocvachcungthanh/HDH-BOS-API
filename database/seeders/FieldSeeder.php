<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Field')->insert([
            [
                'name'          => 'Lĩnh vực bán hàng',
                'note'          => 'Lĩnh vực bán hàng',
                'created_at'    => now()
            ],

            [
                'name'          => 'Lĩnh vực Marketing',
                'note'          => 'Lĩnh vực Marketing',
                'created_at'    => now()
            ],

            [
                'name'          => 'Lĩnh vực hỗ trợ',
                'note'          => 'Lĩnh vực hỗ trợ',
                'created_at'    => now()
            ],

            [
                'name'          => 'Lĩnh vực cung ứng',
                'note'          => 'Lĩnh vực cung ứng',
                'created_at'    => now()
            ]
        ]);
    }
}
