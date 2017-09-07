<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class TablesController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get tables form table tables
        $tables = Table::Active()->get();

        // load view from frontend/home and send $tables to view
        return view('frontend.table-details', compact('tables', 'id'));
    }

    public function tableDetails(Request $request)
    {
        $table_id = $request->input('table_id');
        $table = Table::findOrFail($table_id);
        $categories = Category::nested()->get();
        $featuredProducts = Product::Featured(Product::FEATURED)->Active(Product::ACTIVE)->get();

        // load view from frontend/home and send $tables to view
        return view('frontend.table-details', compact('table', 'categories', 'featuredProducts'));
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Category::where('parent_id', $request->input('category_id'))->get();

        return response()->json($subcategories);
    }

    public function getProducts(Request $request)
    {
        $subcategory = Category::find($request->input('subcategory_id'));

        return response()->json($subcategory->products);
    }

    public function addProductOrder(Request $request)
    {

        $product = OrderProduct::where([
            'order_id' => $request->input('order_id'),
            'product_id' => $request->input('product_id')
            ])->first();

        if($product){
            $product->product_quantity = $product->product_quantity + 1;

            $product->save();
            $order = Order::find($request->input('order_id'));

            $total = [];
            $discount = null;
            $priceWithDiscount = null;
            $isDiscount = false;

            if($order){
                foreach($order->products as $item){
                    $total[] = $item->quantity()->where('order_id', $order->id)->first()->product_quantity * $item->price;
                }

            if($order->discount_id != null){
                $discountValue = $order->discount->value;
                $discount =  number_format(array_sum($total) * $discountValue, 2, ',', '.');
                $priceWithDiscount = number_format(array_sum($total) - array_sum($total) * $discountValue, 2, ',', '.');
                $isDiscount = true;
            }

            }

            $product->total_price = number_format(array_sum($total), 2, ',', '.');
            $product->isDiscount = $isDiscount;
            $product->discount = $discount;
            $product->waiter_color = $order->waiter->color;
            $product->priceWithDiscount = $priceWithDiscount;
            $product->first = false;
            $product->price = Product::find($request->input('product_id')) ?  number_format($product->product_quantity * Product::find($request->input('product_id'))->price, 2, ',', '.') : null;
            $product->table_id = $request->input('table_id');
            return $product;
        }


        if(!$request->exists('order_id')) {

            $newOrder = Order::create([
                'user_id' => Auth::user()->id,
                'table_id' => $request->input('table_id')
            ]);

            if ($newOrder) {
                $orderProduct = OrderProduct::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $request->input('product_id')
                ]);

                foreach($newOrder->products as $item){
                    $total[] = $item->quantity()->where('order_id', $newOrder->id)->first()->product_quantity * $item->price;
                }

                $product = Product::find($request->input('product_id'));
                $product->first = true;
                $product->table_id = $request->input('table_id');
                $product->order_id = $newOrder->id;
                $product->waiter =  Auth::user()->name;
                $product->waiter_color = $newOrder->waiter->color;
                $product->table_number = $newOrder->table->number;
                $product->price = number_format($product->price, 2, ',', '.');
                $product->total_price = number_format(array_sum($total), 2, ',', '.');
                return $product;
            }
        }else{

            $orderProduct = OrderProduct::create($request->all());

            if($orderProduct){
                $order = Order::find($orderProduct->order_id);

                foreach($order->products as $item){
                    $total[] = $item->quantity()->where('order_id', $order->id)->first()->product_quantity * $item->price;
                }

                $discount = null;
                $priceWithDiscount = null;
                $isDiscount = false;

                if($order->discount_id != null){
                    $discountValue = $order->discount->value;
                    $discount =  number_format(array_sum($total) * $discountValue, 2, ',', '.');
                    $priceWithDiscount = number_format(array_sum($total) - array_sum($total) * $discountValue, 2, ',', '.');
                    $isDiscount = true;
                }


                $product = Product::find($request->input('product_id'));
                $product->first = true;
                $product->table_id = $request->input('table_id');
                $product->order_id = $request->input('order_id');
                $product->isDiscount = $isDiscount;
                $product->discount = $discount;
                $product->priceWithDiscount = $priceWithDiscount;
                $product->total_price = number_format(array_sum($total), 2, ',', '.');;
                $product->table_id = $request->input('table_id');
                $product->waiter_color = $order->waiter->color;
                $product->waiter =  Auth::user()->name;
                $product->price = number_format($product->price, 2, ',', '.');
                $product->table_number = $order->table->number;
                return $product;
            }
        }

    }

    public function changeItems(Request $request){

        $order = Order::find($request->input('order_id'));

        return view('frontend.change-items', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
