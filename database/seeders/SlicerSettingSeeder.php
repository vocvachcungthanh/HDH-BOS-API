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
                'slicer_id'     => 5,
                'title'         => 'Trực thuộc',
                'caption'       => 'Trực thuộc',
                'icon'          => 'apartment',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 6,
                'title'         => 'Tên phòng ban',
                'caption'       => 'Tên phòng ban',
                'icon'          => 'build',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 7,
                'title'         => 'Mã vị trí',
                'caption'       => 'Mã vị trí',
                'icon'          => 'barcode',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 8,
                'title'         => 'Tên vị trí',
                'caption'       => 'Tên vị trí',
                'icon'          => 'build',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 9,
                'title'         => 'Loại tài khoản',
                'caption'       => 'Loại tài khoản',
                'icon'          => 'account-book',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 10,
                'title'         => 'Quyền hạn',
                'caption'       => 'Quyền hạn',
                'icon'          => 'fire',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 11,
                'title'         => 'Quyền lợi',
                'caption'       => 'Quyền lợi',
                'icon'          => 'funnel-plot',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }
}
