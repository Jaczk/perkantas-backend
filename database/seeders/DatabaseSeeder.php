<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Good;
use App\Models\Loan;
use App\Models\User;
use App\Models\Category;
use App\Models\Item_Loan;
use App\Models\Procurement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //Procurement::factory(5)->create();
        User::factory(5)->create();
        //Category::factory(6)->create();
        //Good::factory(30)->create();
        //Loan::factory(15)->create();
        //Item_Loan::factory(25)->create();
    }
}
