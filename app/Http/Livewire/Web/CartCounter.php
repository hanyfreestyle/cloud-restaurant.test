<?php

namespace App\Http\Livewire\Web;

use Livewire\Component;
use Cart;

class CartCounter extends Component
{
    // En Livewire 3, debemos usar el método para los eventos
    public function cartUpdated()
    {
        // Este método será llamado cuando se emita el evento 'cartUpdated'
        // No necesita hacer nada ya que Livewire 3 se refrescará automáticamente
    }
    
    public function render()
    {
        $count = Cart::count();
        return view('web.livewire.cart-counter', compact('count'));
    }
}
