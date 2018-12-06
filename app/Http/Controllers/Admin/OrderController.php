<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function order()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        $count = Order::count();
        return view('admin.order.order', ['orders' => $orders, 'count' => $count]);
    }


}
