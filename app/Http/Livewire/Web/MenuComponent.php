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
                // No need to call loadProducts as we show all products
            }
        }
    }
    
    // Remove obsolete loadProducts method
    // We load all products in render()
    
    public function setCategory($categoryId)
    {
        $this->activeCategory = $categoryId;
        $this->dispatchBrowserEvent('category-changed', [
            'categoryId' => $categoryId
        ]);
    }
    
    public function showProductVariants($productId)
    {
        $this->selectedProduct = Product::with('productVariants')->find($productId);
        $this->quantity = 1;
        $this->showVariantModal = true;
    }
    
    public function addToCart($productId, $directAdd = false)
    {
        try {
            if ($directAdd) {
                // Direct add without variants
                $product = Product::find($productId);
                
                if ($product) {
                    // Generate a unique ID for the cart item
                    $uniqueId = $product->id;
                    
                    // Make sure to get the image URL properly
                    $imageUrl = $product->image ? asset('storage/' . $product->image) : null;
                    
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
                    
                    session()->flash('message', __('Product added to cart!'));
                    $this->dispatch('cartUpdated');
                }
            } else {
                // Add with variant
                $product = $this->selectedProduct;
                $variantId = $this->selectedVariants['variant_id'] ?? null;
                
                if ($product && $variantId) {
                    $variant = ProductVariant::find($variantId);
                    
                    if ($variant) {
                        // Generate a unique ID for the cart item
                        $uniqueId = $product->id . '-' . $variant->id;
                        
                        // Make sure to get the image URL properly
                        $imageUrl = $product->image ? asset('storage/' . $product->image) : null;
                        
                        Cart::add([
                            'id' => $uniqueId, 
                            'name' => $product->name . ' - ' . $variant->name,
                            'qty' => $this->quantity,
                            'price' => (float)$variant->price_modifier, // Use the full price of the variant
                            'options' => [
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'variant_name' => $variant->name,
                                'image' => $imageUrl
                            ]
                        ]);
                        
                        session()->flash('message', __('Product added to cart!'));
                        $this->dispatch('cartUpdated');
                        $this->showVariantModal = false;
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error adding to cart: ' . $e->getMessage());
            session()->flash('error', __('Failed to add product to cart. Please try again.'));
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
        // For showing all products grouped by category
        $categoriesWithProducts = $this->categories->map(function($category) {
            $category->products = Product::where('category_id', $category->id)
                ->where('is_active', true)
                ->get();
            return $category;
        });
        
        return view('web.livewire.menu-component', [
            'categoriesWithProducts' => $categoriesWithProducts
        ])
            ->layout('web.layouts.app', ['title' => __('Menu')]);
    }
}
