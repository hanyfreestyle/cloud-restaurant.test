<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Cart;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Get active restaurant
        $restaurant = Restaurant::where('is_active', true)->first();
        
        $categories = [];
        $categoriesWithProducts = [];
        $activeCategory = null;
        
        if ($restaurant) {
            // Get active categories
            $categories = Category::where('restaurant_id', $restaurant->id)
                ->where('is_active', true)
                ->orderBy('position')
                ->get();
                
            // Set active category to the one in request or the first one if available
            if ($request->has('category')) {
                $activeCategory = $request->category;
            } elseif ($categories->count() > 0) {
                $activeCategory = $categories->first()->id;
            }
            
            // Get all products for all categories
            $categoriesWithProducts = $categories->map(function($category) {
                $category->products = Product::where('category_id', $category->id)
                    ->where('is_active', true)
                    ->get();
                return $category;
            });
        }
        
        return view('web.menu.index', compact('restaurant', 'categories', 'categoriesWithProducts', 'activeCategory'));
    }
    
    public function selectCategory(Request $request)
    {
        return redirect()->route('menu', ['category' => $request->category_id]);
    }
    
    public function addToCart(Request $request)
    {
        try {
            if ($request->direct_add) {
                // Direct add without variants
                $product = Product::find($request->product_id);
                
                if ($product) {
                    // Generate a unique ID for the cart item
                    $uniqueId = $product->id;
                    
                    // Make sure to get the image URL properly
                    $imageUrl = null;
                    
                    if (filter_var($product->image, FILTER_VALIDATE_URL)) {
                        $imageUrl = $product->image;
                    } elseif ($product->getFirstMediaUrl('products')) {
                        $imageUrl = $product->getFirstMediaUrl('products');
                    } elseif ($product->image) {
                        $imageUrl = asset('storage/' . $product->image);
                    }
                    
                    Cart::add([
                        'id' => $uniqueId,
                        'name' => $product->name,
                        'qty' => 1,
                        'price' => (float)$product->price,
                        'options' => [
                            'product_id' => $product->id,
                            'variant_id' => null,
                            'variant_name' => null,
                            'image' => $imageUrl
                        ]
                    ]);
                    
                    return redirect()->back()->with('message', __('Product added to cart!'));
                }
            } else {
                // Add with variant
                $product = Product::find($request->product_id);
                $variantId = $request->variant_id;
                
                if ($product && $variantId) {
                    $variant = ProductVariant::find($variantId);
                    
                    if ($variant) {
                        // Generate a unique ID for the cart item
                        $uniqueId = $product->id . '-' . $variant->id;
                        
                        // Make sure to get the image URL properly
                        $imageUrl = null;
                        
                        if (filter_var($product->image, FILTER_VALIDATE_URL)) {
                            $imageUrl = $product->image;
                        } elseif ($product->getFirstMediaUrl('products')) {
                            $imageUrl = $product->getFirstMediaUrl('products');
                        } elseif ($product->image) {
                            $imageUrl = asset('storage/' . $product->image);
                        }
                        
                        Cart::add([
                            'id' => $uniqueId, 
                            'name' => $product->name . ' - ' . $variant->name,
                            'qty' => $request->quantity ?? 1,
                            'price' => (float)$variant->price_modifier, // Use the full price of the variant
                            'options' => [
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'variant_name' => $variant->name,
                                'image' => $imageUrl
                            ]
                        ]);
                        
                        return redirect()->back()->with('message', __('Product added to cart!'));
                    }
                }
            }
            
            return redirect()->back()->with('error', __('Failed to add product to cart. Please try again.'));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to add product to cart. Please try again.'));
        }
    }
}