<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class CashController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cash(Request $request)
    {
        $order_id = $request->input('order_id');
        $order = Order::findOrFail($order_id);

        return view('frontend.cash', compact('order'));
    }

    public function payment(Request $request)
    {
        $order_id = $request->input('order_id');
        $order = Order::findOrFail($order_id);
        $order->status = Order::PAID;

        if($order->save()){
            $order->table_number = $order->table->number;
            return $order;
        }

        return [];
    }
}
