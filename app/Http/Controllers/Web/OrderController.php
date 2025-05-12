<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success()
    {
        // This would typically check for a specific order ID in session
        // and show details about the order that was just placed
        
        return view('web.order.success');
    }
}
