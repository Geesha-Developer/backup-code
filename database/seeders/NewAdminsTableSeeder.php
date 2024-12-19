<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class NewAdminsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            [
            'name' => 'Amren',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456789'),
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Sumit',
            'email' => 'sumit@geesahsolutions.com',
            'password' => bcrypt('sumit007@'),
            'created_at' => now(),
            'updated_at' => now(),
            ]
            
        ],
        
    );
    }
}
