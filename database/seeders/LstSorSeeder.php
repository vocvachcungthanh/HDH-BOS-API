<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LstSorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Sor')->insert([
            [
                'name'          => 'BOS',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'Sổ bán hàng kế toán',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }
}
