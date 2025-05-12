<?php

namespace App\Http\Livewire\Web;

use Livewire\Component;
use Cart;

class CartCounter extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];
    
    public function render()
    {
        return view('web.livewire.cart-counter', [
            'count' => Cart::count()
        ]);
    }
}
