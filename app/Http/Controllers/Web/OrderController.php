<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success()
    {
        if (!session()->has('order_id')) {
            return redirect()->route('home');
        }
        
        $orderId = session('order_id');
        
        return view('web.order.success', [
            'orderId' => $orderId,
            'message' => session('message')
        ]);
    }
}
