<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->insert([
            [
                'staff_id'          => 1,
                'company_id'        => 1,
                'name'              => 'admin',
                'user_name'         => 'admin',
                'email'             => 'vocvachcungthanh@gmail.com',
                'password'          => Hash::make('admin123'),
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
                'password'          => Hash::make('admin123'),
                'remember_token'    => Str::random(60),
                'created_at'        => now(),
                'updated_at'        => now()
            ]
        ]);
    }
}
