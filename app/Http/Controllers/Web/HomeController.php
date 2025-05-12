<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active restaurant (in a real application, you might have multiple restaurants)
        $restaurant = Restaurant::where('is_active', true)->first();
        
        if (!$restaurant) {
            return view('web.home.index');
        }
        
        // Get active categories
        $categories = Category::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->orderBy('position')
            ->get();
            
        // Get featured products (4 random active products)
        $featuredProducts = Product::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
            
        return view('web.home.index', compact('restaurant', 'categories', 'featuredProducts'));
    }
}
