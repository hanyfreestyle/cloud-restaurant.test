<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            $restaurant = $category->restaurant;
            $categoryName = $category->getTranslation('name', 'en');

            if ($categoryName === 'Chicken') {
                $this->createChickenProducts($category, $restaurant);
            } elseif ($categoryName === 'Drinks') {
                $this->createDrinkProducts($category, $restaurant);
            } elseif ($categoryName === 'Salads') {
                $this->createSaladProducts($category, $restaurant);
            }
        }
    }

    private function createChickenProducts($category, $restaurant)
    {
        $products = [
            [
                'name' => 'فراخ بانية',
                'name:en' => 'Fried Chicken',
                'description' => 'فراخ بانية مقرمشة ومقلية تقدم مع البطاطس والصلصة',
                'description:en' => 'Crispy fried chicken served with fries and sauce',
                'slug' => $restaurant->slug . '-fried-chicken',
                'price' => 100,
                'variants' => [
                    [
                        'name' => 'صغير',
                        'option' => 'Small',
                        'price_modifier' => 90,
                    ],
                    [
                        'name' => 'كبير',
                        'option' => 'Large',
                        'price_modifier' => 120,
                    ],
                    [
                        'name' => 'مع جبنة',
                        'option' => 'With Cheese',
                        'price_modifier' => 130,
                    ],
                ],
            ],
            [
                'name' => 'فراخ مشوية',
                'name:en' => 'Grilled Chicken',
                'description' => 'فراخ مشوية طازجة تقدم مع الأرز والخضار',
                'description:en' => 'Fresh grilled chicken served with rice and vegetables',
                'slug' => $restaurant->slug . '-grilled-chicken',
                'price' => 120,
                'variants' => [
                    [
                        'name' => 'نصف فرخة',
                        'option' => 'Half Chicken',
                        'price_modifier' => 70,
                    ],
                    [
                        'name' => 'فرخة كاملة',
                        'option' => 'Whole Chicken',
                        'price_modifier' => 130,
                    ],
                ],
            ],
            [
                'name' => 'كرسبي تشيكن',
                'name:en' => 'Crispy Chicken',
                'description' => 'قطع دجاج مقرمشة مع صوص خاص',
                'description:en' => 'Crispy chicken pieces with special sauce',
                'slug' => $restaurant->slug . '-crispy-chicken',
                'price' => 90,
                'variants' => [
                    [
                        'name' => '6 قطع',
                        'option' => '6 Pieces',
                        'price_modifier' => 90,
                    ],
                    [
                        'name' => '12 قطعة',
                        'option' => '12 Pieces',
                        'price_modifier' => 160,
                    ],
                ],
            ],
        ];

        $this->createProductsWithVariants($products, $category, $restaurant);
    }

    private function createDrinkProducts($category, $restaurant)
    {
        $products = [
            [
                'name' => 'كولا',
                'name:en' => 'Cola',
                'description' => 'مشروب غازي منعش',
                'description:en' => 'Refreshing fizzy drink',
                'slug' => $restaurant->slug . '-cola',
                'price' => 15,
                'variants' => [
                    [
                        'name' => 'عبوة صغيرة',
                        'option' => 'Small',
                        'price_modifier' => 15,
                    ],
                    [
                        'name' => 'عبوة كبيرة',
                        'option' => 'Large',
                        'price_modifier' => 25,
                    ],
                ],
            ],
            [
                'name' => 'عصير برتقال',
                'name:en' => 'Orange Juice',
                'description' => 'عصير برتقال طازج',
                'description:en' => 'Fresh orange juice',
                'slug' => $restaurant->slug . '-orange-juice',
                'price' => 30,
                'variants' => [
                    [
                        'name' => 'كوب صغير',
                        'option' => 'Small Glass',
                        'price_modifier' => 30,
                    ],
                    [
                        'name' => 'كوب كبير',
                        'option' => 'Large Glass',
                        'price_modifier' => 45,
                    ],
                ],
            ],
            [
                'name' => 'مياه معدنية',
                'name:en' => 'Mineral Water',
                'description' => 'مياه معدنية نقية',
                'description:en' => 'Pure mineral water',
                'slug' => $restaurant->slug . '-mineral-water',
                'price' => 10,
                'variants' => [
                    [
                        'name' => 'عبوة صغيرة',
                        'option' => 'Small Bottle',
                        'price_modifier' => 10,
                    ],
                    [
                        'name' => 'عبوة كبيرة',
                        'option' => 'Large Bottle',
                        'price_modifier' => 20,
                    ],
                ],
            ],
        ];

        $this->createProductsWithVariants($products, $category, $restaurant);
    }

    private function createSaladProducts($category, $restaurant)
    {
        $products = [
            [
                'name' => 'سلطة خضراء',
                'name:en' => 'Green Salad',
                'description' => 'سلطة خضراء طازجة مع صلصة الليمون',
                'description:en' => 'Fresh green salad with lemon dressing',
                'slug' => $restaurant->slug . '-green-salad',
                'price' => 50,
                'variants' => [
                    [
                        'name' => 'طبق صغير',
                        'option' => 'Small Plate',
                        'price_modifier' => 50,
                    ],
                    [
                        'name' => 'طبق كبير',
                        'option' => 'Large Plate',
                        'price_modifier' => 80,
                    ],
                ],
            ],
            [
                'name' => 'سلطة سيزر',
                'name:en' => 'Caesar Salad',
                'description' => 'خس روماني، خبز محمص، جبنة بارميزان، وصلصة سيزر',
                'description:en' => 'Romaine lettuce, croutons, parmesan cheese, and Caesar dressing',
                'slug' => $restaurant->slug . '-caesar-salad',
                'price' => 65,
                'variants' => [
                    [
                        'name' => 'بدون دجاج',
                        'option' => 'Without Chicken',
                        'price_modifier' => 65,
                    ],
                    [
                        'name' => 'مع دجاج',
                        'option' => 'With Chicken',
                        'price_modifier' => 90,
                    ],
                ],
            ],
            [
                'name' => 'سلطة فواكه',
                'name:en' => 'Fruit Salad',
                'description' => 'تشكيلة من الفواكه الطازجة الموسمية',
                'description:en' => 'Assortment of fresh seasonal fruits',
                'slug' => $restaurant->slug . '-fruit-salad',
                'price' => 55,
                'variants' => [
                    [
                        'name' => 'طبق عادي',
                        'option' => 'Regular',
                        'price_modifier' => 55,
                    ],
                    [
                        'name' => 'مع آيس كريم',
                        'option' => 'With Ice Cream',
                        'price_modifier' => 75,
                    ],
                ],
            ],
        ];

        $this->createProductsWithVariants($products, $category, $restaurant);
    }

    private function createProductsWithVariants($products, $category, $restaurant)
    {
        foreach ($products as $productData) {
            $product = Product::create([
                'id' => Uuid::uuid4()->toString(),
                'category_id' => $category->id,
                'restaurant_id' => $restaurant->id,
                'slug' => $productData['slug'],
                'price' => $productData['price'],
                'regular_price' => $productData['price'] * 1.2, // 20% higher as regular price
                'is_active' => true,
                'name' => $productData['name'],
                'name:en' => $productData['name:en'],
                'description' => $productData['description'],
                'description:en' => $productData['description:en'],
            ]);

            // Create variants for the product
            foreach ($productData['variants'] as $variantData) {
                ProductVariant::create([
                    'id' => Uuid::uuid4()->toString(),
                    'product_id' => $product->id,
                    'name' => $variantData['name'],
                    'option' => $variantData['option'],
                    'price_modifier' => $variantData['price_modifier'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
