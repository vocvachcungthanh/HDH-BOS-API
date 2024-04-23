<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlicerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('slicer')->insert([
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
        ]);
    }
}
