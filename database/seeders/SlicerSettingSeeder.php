<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SlicerSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slicerSetting = Helper::insert_with_unicode([
            [
                'slicer_id'     => 1,
                'title'         => 'Mã phòng ban',
                'caption'       => 'Mã phòng ban',
                'icon'          => 'CodeOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 2,
                'title'         => 'Tên phòng ban',
                'caption'       => 'Tên phòng ban',
                'icon'          => 'DeploymentUnitOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 3,
                'title'         => 'Khối',
                'caption'       => 'Khối',
                'icon'          => 'BlockOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 4,
                'title'         => 'Lĩnh vực',
                'caption'       => 'Lĩnh vực',
                'icon'          => 'RiseOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'slicer_id'     => 5,
                'title'         => 'Trực thuộc',
                'caption'       => 'Trực thuộc',
                'icon'          => 'ApartmentOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 6,
                'title'         => 'Tên phòng ban',
                'caption'       => 'Tên phòng ban',
                'icon'          => 'GoldOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 7,
                'title'         => 'Mã vị trí',
                'caption'       => 'Mã vị trí',
                'icon'          => 'EnvironmentOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 8,
                'title'         => 'Tên vị trí',
                'caption'       => 'Tên vị trí',
                'icon'          => 'EnvironmentOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 9,
                'title'         => 'Loại tài khoản',
                'caption'       => 'Loại tài khoản',
                'icon'          => 'AccountBookOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 10,
                'title'         => 'Quyền hạn',
                'caption'       => 'Quyền hạn',
                'icon'          => 'AppstoreAddOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'slicer_id'     => 11,
                'title'         => 'Quyền lợi',
                'caption'       => 'Quyền lợi',
                'icon'          => 'BorderOuterOutlined',
                'count'         => 2,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);



        DB::table('slicer_setting')->insert($slicerSetting);
    }
}
