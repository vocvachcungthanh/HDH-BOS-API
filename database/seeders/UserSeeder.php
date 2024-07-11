<?php

/**
 * Auth: Nguyen_Huu_Thanh
 * Date By: 24/06/2024
 * Description: Tạo dữ liệu mẫu cho phần User 
 */

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Auth: Nguyen_Huu_Thanh
         * Date By: 24/06/2024
         * Description: Xóa hết dư liệu hiện tại trước khi chèn dữ liệu mới
         */
        DB::table('users')->delete();

        /**
         * Auth: Nguyen_Huu_Thanh
         * Date By: 24/06/2024
         * Description: tạo dư liệu mẫu
         */

        $users = Helper::insert_with_unicode([
            [
                'staff_id'          => 1,
                'company_id'        => 1,
                'name'              => 'Nguyễn hữu Thành',
                'user_name'         => 'cafedev93',
                'email'             => 'cafedev93@gmail.com',
                'password'          => Hash::make('Admin@123'),
                'remember_token'    => Str::random(60),
                'created_at'        => now(),
                'updated_at'        => now()
            ],

            [
                'staff_id'          => 1,
                'company_id'        => 1,
                'name'              => 'admin2',
                'user_name'         => 'admin2',
                'email'             => 'vocvachcungthanh2@gmail.com',
                'password'          => Hash::make('Admin@123'),
                'remember_token'    => Str::random(60),
                'created_at'        => now(),
                'updated_at'        => now()
            ],

            /**
             * Auth: Nguyen_Huu_Thanh
             * Date By: 24/06/2024
             * Description: Thêm dữ liệu để test email check otp
             */
            [
                'staff_id'          => 1,
                'company_id'        => 1,
                'name'              => 'admin2',
                'user_name'         => 'admin2',
                'email'             => 'thanhit28081993.com',
                'password'          => Hash::make('Admin@123'),
                'remember_token'    => Str::random(60),
                'created_at'        => now(),
                'updated_at'        => now()
            ]
        ]);

        DB::table('users')->insert($users);
    }
}
