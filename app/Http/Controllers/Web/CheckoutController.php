<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use FreestyleRepo\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;


class CheckoutController extends Controller {
    public function index() {
        $cartItems = Cart::content();
        $cartTotal = Cart::total();

        if ($cartItems->count() === 0) {
            return redirect()->route('menu')->with('error', __('Your cart is empty. Please add items before checkout.'));
        }

        return view('web.checkout.index', compact('cartItems', 'cartTotal'));
    }

    public function processCheckout(Request $request) {
        // Validate form input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:cash,credit_card',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::content();
        $cartTotal = floatval(str_replace(',', '', Cart::total()));

        if ($cartItems->count() === 0) {
            return redirect()->route('menu')->with('error', __('Your cart is empty. Please add items before checkout.'));
        }

        // Get active restaurant
        $restaurant = Restaurant::where('is_active', true)->first();

        if (!$restaurant) {
            return redirect()->back()->with('error', __('No active restaurant found.'));
        }

        // Create order
        $order = new Order();
        $order->restaurant_id = $restaurant->id;
        $order->customer_name = $validated['first_name'] . ' ' . $validated['last_name'];

        // Handle additional fields that may not be in the database yet
        try {
            $order->email = $validated['email'];
            $order->phone = $validated['phone'];
            $order->address = $validated['address'];
            $order->notes = $validated['notes'] ?? null;
            $order->payment_method = $validated['payment_method'];
        } catch (\Exception $e) {
            // Continue without these fields if they don't exist in the database yet
            // Log the error for debugging
            \Log::warning('Field not available in orders table: ' . $e->getMessage());
        }

        $order->status = 'pending';
        $order->payment_status = 'unpaid';
        $order->total_amount = $cartTotal + 15; // Add delivery fee
        $order->save();

        // Create order items
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = isset($item->options['product_id']) ? $item->options['product_id'] : null;
            $orderItem->product_variant_id = isset($item->options['variant_id']) ? $item->options['variant_id'] : null;
            $orderItem->quantity = $item->qty;
            $orderItem->unit_price = $item->price;
            $orderItem->total_price = $item->subtotal;
            $orderItem->save();
        }

        // Clear cart
        Cart::destroy();

        // Redirect to success page
        return redirect()->route('order.success')->with([
            'message' => __('Your order has been placed successfully!'),
            'order_id' => $order->id
        ]);
    }
}
