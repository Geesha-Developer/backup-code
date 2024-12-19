<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        // Insert multiple admin users
        DB::table('admins')->insert([
            [
                'name' => 'Adam',
                'email' => 'adam@cargoconvoy.co',
                'password' => bcrypt('admin@123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sumit Kumar',
                'email' => 'sumit@geeshasolutions.com',
                'password' => bcrypt('sumit007@'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Amrendra Kumar',
                'email' => 'amren@geeshasolutions.com',
                'password' => bcrypt('CCIWILLOWN@2024'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'RAJINDER SINGH',
                'email' => 'raj@cargoconvoy.co',
                'password' => bcrypt('rajcargo@2024'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
