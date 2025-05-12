<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            // Create 10 tables for each restaurant
            for ($i = 1; $i <= 10; $i++) {
                Table::create([
                    'id' => Uuid::uuid4()->toString(),
                    'restaurant_id' => $restaurant->id,
                    'table_number' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'capacity' => $i % 3 === 0 ? 6 : ($i % 2 === 0 ? 4 : 2), // Mix of 2, 4, 6 seater tables
                    'is_active' => true,
                ]);
            }
        }
    }
}
