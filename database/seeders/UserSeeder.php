<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'name' => 'Admin',
                'email' => 'admin@try.com',
                'password' =>Hash::make('Cobaadmin*'),
                'roles'=> 1,
                'phone' => '085803650740',
                'created_at' =>now(),
                'updated_at' => now()
            ]
        );
    }
}
