<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
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
            
            // Get category name from translations
            $categoryName = null;
            foreach($category->translations as $translation) {
                if ($translation->locale === 'en') {
                    $categoryName = $translation->name;
                    break;
                }
            }
            
            if (!$categoryName) {
                continue; // Skip if no English name found
            }

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
                'name_en' => 'Fried Chicken',
                'description' => 'فراخ بانية مقرمشة ومقلية تقدم مع البطاطس والصلصة',
                'description_en' => 'Crispy fried chicken served with fries and sauce',
                'slug' => $restaurant->slug . '-fried-chicken',
                'price' => 100,
                'image_url' => 'https://images.pexels.com/photos/1059943/pexels-photo-1059943.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Grilled Chicken',
                'description' => 'فراخ مشوية طازجة تقدم مع الأرز والخضار',
                'description_en' => 'Fresh grilled chicken served with rice and vegetables',
                'slug' => $restaurant->slug . '-grilled-chicken',
                'price' => 120,
                'image_url' => 'https://images.pexels.com/photos/2338407/pexels-photo-2338407.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Crispy Chicken',
                'description' => 'قطع دجاج مقرمشة مع صوص خاص',
                'description_en' => 'Crispy chicken pieces with special sauce',
                'slug' => $restaurant->slug . '-crispy-chicken',
                'price' => 90,
                'image_url' => 'https://images.pexels.com/photos/2741448/pexels-photo-2741448.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Cola',
                'description' => 'مشروب غازي منعش',
                'description_en' => 'Refreshing fizzy drink',
                'slug' => $restaurant->slug . '-cola',
                'price' => 15,
                'image_url' => 'https://images.pexels.com/photos/2983101/pexels-photo-2983101.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Orange Juice',
                'description' => 'عصير برتقال طازج',
                'description_en' => 'Fresh orange juice',
                'slug' => $restaurant->slug . '-orange-juice',
                'price' => 30,
                'image_url' => 'https://images.pexels.com/photos/3652639/pexels-photo-3652639.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Mineral Water',
                'description' => 'مياه معدنية نقية',
                'description_en' => 'Pure mineral water',
                'slug' => $restaurant->slug . '-mineral-water',
                'price' => 10,
                'image_url' => 'https://images.pexels.com/photos/1000084/pexels-photo-1000084.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Green Salad',
                'description' => 'سلطة خضراء طازجة مع صلصة الليمون',
                'description_en' => 'Fresh green salad with lemon dressing',
                'slug' => $restaurant->slug . '-green-salad',
                'price' => 50,
                'image_url' => 'https://images.pexels.com/photos/1211887/pexels-photo-1211887.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Caesar Salad',
                'description' => 'خس روماني، خبز محمص، جبنة بارميزان، وصلصة سيزر',
                'description_en' => 'Romaine lettuce, croutons, parmesan cheese, and Caesar dressing',
                'slug' => $restaurant->slug . '-caesar-salad',
                'price' => 65,
                'image_url' => 'https://images.pexels.com/photos/7363781/pexels-photo-7363781.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
                'name_en' => 'Fruit Salad',
                'description' => 'تشكيلة من الفواكه الطازجة الموسمية',
                'description_en' => 'Assortment of fresh seasonal fruits',
                'slug' => $restaurant->slug . '-fruit-salad',
                'price' => 55,
                'image_url' => 'https://images.pexels.com/photos/1132047/pexels-photo-1132047.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
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
            // Create the product
            $productId = Uuid::uuid4()->toString();
            
            $product = new Product();
            $product->id = $productId;
            $product->category_id = $category->id;
            $product->restaurant_id = $restaurant->id;
            $product->slug = $productData['slug'];
            $product->price = $productData['price'];
            $product->regular_price = $productData['price'] * 1.2; // 20% higher as regular price
            $product->is_active = true;
            $product->image = $productData['image_url'];
            $product->save();
            
            // Create Arabic translation
            $arTranslation = new ProductTranslation();
            $arTranslation->product_id = $productId;
            $arTranslation->locale = 'ar';
            $arTranslation->name = $productData['name'];
            $arTranslation->description = $productData['description'];
            $arTranslation->save();
            
            // Create English translation
            $enTranslation = new ProductTranslation();
            $enTranslation->product_id = $productId;
            $enTranslation->locale = 'en';
            $enTranslation->name = $productData['name_en'];
            $enTranslation->description = $productData['description_en'];
            $enTranslation->save();

            // Create variants for the product
            foreach ($productData['variants'] as $variantData) {
                ProductVariant::create([
                    'id' => Uuid::uuid4()->toString(),
                    'product_id' => $productId,
                    'name' => $variantData['name'],
                    'option' => $variantData['option'],
                    'price_modifier' => $variantData['price_modifier'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
