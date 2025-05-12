<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();
        $statuses = ['pending', 'preparing', 'ready', 'delivered', 'canceled'];
        $paymentStatuses = ['paid', 'unpaid', 'partially_paid'];
        
        foreach ($restaurants as $restaurant) {
            $tables = Table::where('restaurant_id', $restaurant->id)->get();
            $products = Product::where('restaurant_id', $restaurant->id)->get();
            
            // Skip if there are no tables or products
            if ($tables->isEmpty() || $products->isEmpty()) {
                continue;
            }
            
            // Create 5 orders for each restaurant
            for ($i = 0; $i < 5; $i++) {
                $table = $tables->random();
                $status = $statuses[array_rand($statuses)];
                $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
                
                $order = Order::create([
                    'id' => Uuid::uuid4()->toString(),
                    'restaurant_id' => $restaurant->id,
                    'table_id' => $table->id,
                    'customer_name' => 'Customer ' . ($i + 1),
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'total_amount' => 0, // Will be calculated based on order items
                ]);
                
                // Add 2-4 items to each order
                $itemCount = rand(2, 4);
                $totalAmount = 0;
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $productVariant = null;
                    $variants = ProductVariant::where('product_id', $product->id)->get();
                    
                    if ($variants->isNotEmpty() && rand(0, 1) === 1) {
                        $productVariant = $variants->random();
                        $unitPrice = $productVariant->price_modifier;
                    } else {
                        $unitPrice = $product->price;
                    }
                    
                    $quantity = rand(1, 3);
                    $totalPrice = $unitPrice * $quantity;
                    $totalAmount += $totalPrice;
                    
                    OrderItem::create([
                        'id' => Uuid::uuid4()->toString(),
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => $productVariant ? $productVariant->id : null,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $totalPrice,
                    ]);
                }
                
                // Update order total
                $order->update(['total_amount' => $totalAmount]);
            }
        }
    }
}
