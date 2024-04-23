<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SlicerSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('slicer_setting')->insert([
            [
                'slicer_id'     => 1,
                'title'         => 'Mã phòng ban',
                'caption'       => 'Mã phòng ban',
                'icon'          => 'barcode',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 2,
                'title'         => 'Tên phòng ban',
                'caption'       => 'Tên phòng ban',
                'icon'          => 'build',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 3,
                'title'         => 'Khối',
                'caption'       => 'Khối',
                'icon'          => 'block',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 4,
                'title'         => 'Lĩnh vực',
                'caption'       => 'Lĩnh vực',
                'icon'          => 'box-plot',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 4,
                'title'         => 'Trực thuộc',
                'caption'       => 'Trực thuộc',
                'icon'          => 'apartment',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }
}
