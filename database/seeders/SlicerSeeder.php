<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlicerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slicer = Helper::insert_with_unicode([
            [
                'name'          => 'slicerCode',
                'note'          => 'slicer mã phòng ban',
                'type'          => 'unit',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'slicerName',
                'note'          => 'slicer tên phòng ban',
                'type'          => 'unit',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'slicerBlock',
                'note'          => 'slicer khối',
                'type'          => 'unit',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'slicerField',
                'note'          => 'slicer lĩnh vực',
                'type'          => 'unit',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'name'          => 'slicerParent',
                'note'          => 'slicer Trực thuộc',
                'type'          => 'unit',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'slicerUnit',
                'note'          => 'slicer tên phòng ban',
                'type'          => 'postion',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'slicerCode',
                'note'          => 'slicer mã vị trí',
                'type'          => 'postion',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'slicerName',
                'note'          => 'slicer tên vị trí',
                'type'          => 'postion',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'slicerAccountType',
                'note'          => 'slicer loại tài khoản',
                'type'          => 'postion',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'slicerPermissions',
                'note'          => 'slicer quyền hạn',
                'type'          => 'postion',
                'created_at'    => now(),
                'updated_at'    => now()
            ],

            [
                'name'          => 'slicerBenefits',
                'note'          => 'slicer quyền lợi',
                'type'          => 'postion',
                'created_at'    => now(),
                'updated_at'    => now()
            ]
        ]);

        DB::table('slicer')->insert($slicer);
    }
}
