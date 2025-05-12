<?php

namespace App\Http\Livewire\Web;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Livewire\Component;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Cart;

class CheckoutComponent extends Component
{
    public $orderType = 'delivery';
    public $name;
    public $phone;
    public $address;
    public $notes;
    public $tableId;
    public $availableTables = [];
    
    public $errors = [];
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ];
    
    public function mount()
    {
        // If cart is empty, redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('cart');
        }
        
        // Load available tables
        $this->loadTables();
    }
    
    public function loadTables()
    {
        $this->availableTables = Table::where('is_active', true)->get();
        
        // Set first table as default if order type is table reservation
        if ($this->orderType == 'table' && count($this->availableTables) > 0) {
            $this->tableId = $this->availableTables[0]->id;
        }
    }
    
    public function changeOrderType($type)
    {
        $this->orderType = $type;
        
        // Reset table selection if not table reservation
        if ($type != 'table') {
            $this->tableId = null;
        } else {
            // Set first available table as default
            if (count($this->availableTables) > 0) {
                $this->tableId = $this->availableTables[0]->id;
            }
        }
    }
    
    public function placeOrder()
    {
        $this->validate();
        
        // Additional validation based on order type
        $this->errors = [];
        
        if ($this->orderType == 'delivery' && empty($this->address)) {
            $this->errors['address'] = __('Address is required for delivery orders.');
            return;
        }
        
        if ($this->orderType == 'table' && empty($this->tableId)) {
            $this->errors['table'] = __('Please select a table.');
            return;
        }
        
        try {
            // Create order
            $orderId = Uuid::uuid4()->toString();
            $order = new Order();
            $order->id = $orderId;
            $order->restaurant_id = session('restaurant_id', null); // You might want to store the restaurant ID in session
            $order->table_id = $this->orderType == 'table' ? $this->tableId : null;
            $order->customer_name = $this->name;
            $order->status = 'pending';
            $order->payment_status = 'unpaid';
            $order->total_amount = Cart::total(0, '', '');
            $order->save();
            
            // Add order meta (like phone, address, etc.)
            // In a real application, you might want to have an OrderMeta model for this
            
            // Create order items
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem();
                $orderItem->id = Uuid::uuid4()->toString();
                $orderItem->order_id = $orderId;
                $orderItem->product_id = $item->options->product_id ?? $item->id;
                $orderItem->product_variant_id = $item->options->variant_id ?? null;
                $orderItem->quantity = $item->qty;
                $orderItem->unit_price = $item->price;
                $orderItem->total_price = $item->subtotal;
                $orderItem->save();
            }
            
            // Clear cart
            Cart::destroy();
            
            // Store order ID in session for order success page
            session(['last_order_id' => $orderId]);
            
            // Redirect to success page
            return redirect()->route('order.success');
        } catch (\Exception $e) {
            $this->errors['general'] = __('Something went wrong. Please try again.');
        }
    }
    
    public function render()
    {
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        
        return view('web.livewire.checkout-component', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ])->layout('web.layouts.app', ['title' => __('Checkout')]);
    }
}
