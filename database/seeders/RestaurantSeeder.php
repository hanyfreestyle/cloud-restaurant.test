<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create first restaurant
        Restaurant::create([
            'id' => Uuid::uuid4()->toString(),
            'slug' => 'egyptian-cuisine',
            'is_active' => true,
        ]);

        // Create second restaurant
        Restaurant::create([
            'id' => Uuid::uuid4()->toString(),
            'slug' => 'italian-corner',
            'is_active' => true,
        ]);
    }
}
