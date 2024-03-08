<?php

namespace Database\Seeders;
use App\Models\Shift;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        Shift::factory()
        ->count(200)
        ->withOrders(1, 5) // Use the withOrders method from ShiftFactory
        ->create();
    }
}
