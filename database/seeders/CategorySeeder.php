<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $index => $restaurant) {
            // Creating categories for each restaurant
            $categories = [
                [
                    'name' => 'فراخ',
                    'name:en' => 'Chicken',
                    'slug' => $restaurant->slug . '-chicken',
                    'position' => 1,
                ],
                [
                    'name' => 'مشروبات',
                    'name:en' => 'Drinks',
                    'slug' => $restaurant->slug . '-drinks',
                    'position' => 2,
                ],
                [
                    'name' => 'سلطات',
                    'name:en' => 'Salads',
                    'slug' => $restaurant->slug . '-salads',
                    'position' => 3,
                ],
            ];

            foreach ($categories as $categoryData) {
                Category::create([
                    'id' => Uuid::uuid4()->toString(),
                    'restaurant_id' => $restaurant->id,
                    'slug' => $categoryData['slug'],
                    'position' => $categoryData['position'],
                    'is_active' => true,
                    'name' => $categoryData['name'],
                    'name:en' => $categoryData['name:en'],
                ]);
            }
        }
    }
}
