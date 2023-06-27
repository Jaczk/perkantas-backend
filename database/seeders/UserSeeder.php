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
                'name' => 'User',
                'email' => 'user@try.com',
                'password' =>Hash::make('Cobauser*'),
                'roles'=> 0,
                'phone' => '085803650741',
                'created_at' =>now(),
                'updated_at' => now()
            ]
        );
    }
}
