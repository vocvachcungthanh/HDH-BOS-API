<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('LST_Account_Type')->insert([
            [
                'name'              => 'Owenr',
                'note'              => '',
                'created_at'        => now(),
            ],

            [
                'name'              => 'Manager',
                'note'              => '',
                'created_at'        => now(),
            ],

            [
                'name'              => 'Admin',
                'note'              => '',
                'created_at'        => now(),
            ],

            [
                'name'              => 'User',
                'note'              => '',
                'created_at'        => now(),
            ],
        ]);
    }
}
