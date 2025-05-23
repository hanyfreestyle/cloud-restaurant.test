<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            RestaurantSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            TableSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
