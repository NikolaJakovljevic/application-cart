<?php

namespace App\Http\Controllers\frontend;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class DiscountController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $discounts = Discount::all();
        $order = Order::find($request->input('order_id'));

        return view('frontend.discount', compact('discounts', 'order'));
    }

    public function calculateDiscount(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        if($order){
            $order->discount_id = $request->input('discount_id');
            $order->save();

            foreach($order->products as $item){
                $total[] = $item->quantity()->where('order_id', $order->id)->first()->product_quantity * $item->price;
            }

            $discountValue = null;
            $discount = null;
            $priceWithDiscount = null;
            $isDiscount = false;

            if($request->input('discount_id') != null){
                $isDiscount = true;
                $discountValue = $order->discount->value;
                $discount =  number_format(array_sum($total) * $discountValue, 2, ',', '.');
                $priceWithDiscount = number_format(array_sum($total) - array_sum($total) * $discountValue, 2, ',', '.');
            }

            $order->isDiscount = $isDiscount;
            $order->total_price = number_format(array_sum($total), 2, ',', '.');
            $order->discountPrice = $discount;
            $order->priceWithDiscount = $priceWithDiscount;
            return $order;
        }
    }


}
