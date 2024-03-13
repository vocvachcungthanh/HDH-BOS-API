<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company')->insert([
            [
                'name'              => 'Công ty CP Giải Pháp Quản Trị BOS',
                'address'           => 'Tầng 10, Tòa 15T Nguyễn Thị Định, Phường Trung Hòa, Cầu Giấy, Hà Nội',
                'phone'             => '0947289966',
                'email'             => 'bos11052021@gmail.com',
                'logo'              => 'https://bos.edu.vn/wp-content/uploads/2022/08/logo_footer.svg',
                'tin'               => '0108159243',
                'website'           => 'https://bos.edu.vn/',
                'hosting_id'        => 1,
                'created_at'        => now(),
                'updated_at'        => now()
            ],
        ]);
    }
}
