<?php

namespace App\Http\Livewire\Web;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    public function removeItem($rowId)
    {
        Cart::remove($rowId);
        $this->dispatch('cartUpdated');
        session()->flash('message', __('Item removed from cart.'));
    }
    
    public function updateQuantity($rowId, $qty)
    {
        $qty = max(1, $qty); // Ensure minimum quantity is 1
        
        Cart::update($rowId, $qty);
        $this->dispatch('cartUpdated');
    }
    
    public function clearCart()
    {
        Cart::destroy();
        $this->dispatch('cartUpdated');
        session()->flash('message', __('Cart has been cleared.'));
    }
    
    public function render()
    {
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        
        return view('web.livewire.cart-component', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ])->layout('web.layouts.app', ['title' => __('Shopping Cart')]);
    }
}
