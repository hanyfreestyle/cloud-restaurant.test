<?php

namespace App\Http\Livewire\Web;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Restaurant;
use Livewire\Component;
use Cart;

class MenuComponent extends Component
{
    public $restaurant;
    public $categories = [];
    public $activeCategory = null;
    public $products = [];
    
    // For product variant selection
    public $showVariantModal = false;
    public $selectedProduct = null;
    public $selectedVariants = [];
    public $quantity = 1;
    
    public function mount()
    {
        // Get active restaurant
        $this->restaurant = Restaurant::where('is_active', true)->first();
        
        if ($this->restaurant) {
            // Get active categories
            $this->categories = Category::where('restaurant_id', $this->restaurant->id)
                ->where('is_active', true)
                ->orderBy('position')
                ->get();
                
            // Set active category to the first one if available
            if ($this->categories->count() > 0) {
                $this->activeCategory = $this->categories->first()->id;
                $this->loadProducts();
            }
        }
    }
    
    public function loadProducts()
    {
        if ($this->activeCategory) {
            $this->products = Product::where('category_id', $this->activeCategory)
                ->where('is_active', true)
                ->get();
        }
    }
    
    public function setCategory($categoryId)
    {
        $this->activeCategory = $categoryId;
        $this->loadProducts();
    }
    
    public function showProductVariants($productId)
    {
        $this->selectedProduct = Product::with('productVariants')->find($productId);
        $this->quantity = 1;
        $this->showVariantModal = true;
    }
    
    public function addToCart($productId, $directAdd = false)
    {
        if ($directAdd) {
            // Direct add without variants
            $product = Product::find($productId);
            
            if ($product) {
                Cart::add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => 1,
                    'price' => $product->price,
                    'options' => [
                        'variant_id' => null,
                        'variant_name' => null,
                        'image' => $product->getFirstMediaUrl('product-image')
                    ]
                ]);
                
                session()->flash('message', __('Product added to cart!'));
                $this->emit('cartUpdated');
            }
        } else {
            // Add with variant
            $product = $this->selectedProduct;
            $variantId = $this->selectedVariants['variant_id'] ?? null;
            
            if ($product && $variantId) {
                $variant = ProductVariant::find($variantId);
                
                if ($variant) {
                    Cart::add([
                        'id' => $product->id . '-' . $variant->id, // Create unique ID for cart item
                        'name' => $product->name . ' - ' . $variant->name,
                        'qty' => $this->quantity,
                        'price' => $variant->price_modifier, // Use the full price of the variant
                        'options' => [
                            'product_id' => $product->id,
                            'variant_id' => $variant->id,
                            'variant_name' => $variant->name,
                            'image' => $product->getFirstMediaUrl('product-image')
                        ]
                    ]);
                    
                    session()->flash('message', __('Product added to cart!'));
                    $this->emit('cartUpdated');
                    $this->showVariantModal = false;
                }
            }
        }
    }
    
    public function selectVariant($variantId, $variantName)
    {
        $this->selectedVariants = [
            'variant_id' => $variantId,
            'variant_name' => $variantName
        ];
    }
    
    public function closeModal()
    {
        $this->showVariantModal = false;
        $this->selectedProduct = null;
        $this->selectedVariants = [];
        $this->quantity = 1;
    }
    
    public function incrementQuantity()
    {
        $this->quantity++;
    }
    
    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    
    public function render()
    {
        return view('web.livewire.menu-component')
            ->layout('web.layouts.app', ['title' => __('Menu')]);
    }
}
