<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        
        return view('web.cart.index', compact('cartItems', 'cartTotal'));
    }
    
    public function updateQuantity(Request $request)
    {
        $rowId = $request->row_id;
        $qty = max(1, (int)$request->qty); // Ensure minimum quantity is 1
        
        Cart::update($rowId, $qty);
        
        return redirect()->back()->with('message', __('Cart updated successfully.'));
    }
    
    public function removeItem(Request $request)
    {
        Cart::remove($request->row_id);
        
        return redirect()->back()->with('message', __('Item removed from cart.'));
    }
    
    public function clearCart()
    {
        Cart::destroy();
        
        return redirect()->back()->with('message', __('Cart has been cleared.'));
    }
}