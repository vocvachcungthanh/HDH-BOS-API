<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LstEsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Es')->insert([
            [
                'name'          => 'Đang làm việc',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'Đã nghỉ việc',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'Dự kiến tuyển dụng',
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }
}
