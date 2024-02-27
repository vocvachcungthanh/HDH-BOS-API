<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hosting')->insert([
            [
                'db_host'           => '14.224.164.177',
                'db_port'           => '1433',
                'db_database'       => 'HDH_BOS_API',
                'db_user_name'      => 'quanTriBos',
                'db_password'       => 'Bos58ToHuu',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
        ]);
    }
}
