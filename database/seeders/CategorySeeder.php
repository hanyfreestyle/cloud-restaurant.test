<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
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
                    'name_en' => 'Chicken',
                    'slug' => $restaurant->slug . '-chicken',
                    'position' => 1,
                ],
                [
                    'name' => 'مشروبات',
                    'name_en' => 'Drinks',
                    'slug' => $restaurant->slug . '-drinks',
                    'position' => 2,
                ],
                [
                    'name' => 'سلطات',
                    'name_en' => 'Salads',
                    'slug' => $restaurant->slug . '-salads',
                    'position' => 3,
                ],
            ];

            foreach ($categories as $categoryData) {
                // Create the category
                $categoryId = Uuid::uuid4()->toString();
                
                $category = new Category();
                $category->id = $categoryId;
                $category->restaurant_id = $restaurant->id;
                $category->slug = $categoryData['slug'];
                $category->position = $categoryData['position'];
                $category->is_active = true;
                $category->save();
                
                // Create Arabic translation
                $arTranslation = new CategoryTranslation();
                $arTranslation->category_id = $categoryId;
                $arTranslation->locale = 'ar';
                $arTranslation->name = $categoryData['name'];
                $arTranslation->save();
                
                // Create English translation
                $enTranslation = new CategoryTranslation();
                $enTranslation->category_id = $categoryId;
                $enTranslation->locale = 'en';
                $enTranslation->name = $categoryData['name_en'];
                $enTranslation->save();
            }
        }
    }
}
