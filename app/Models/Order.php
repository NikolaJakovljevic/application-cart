<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const NOT_PAID = 0;
    const PAID = 1;

    protected $fillable = ['user_id', 'table_id', 'status'];

    public function table()
    {
        return $this->hasOne('App\Models\Table', 'id', 'table_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_products', 'order_id', 'product_id');
    }

    public function waiter()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function discount()
    {
        return $this->hasOne('App\Models\Discount', 'id', 'discount_id');
    }

    public function scopeNotCharged($query)
    {
        $query->where('status', 0);
    }

    public function getTotalPrice()
    {
        $total = [];

        if($this->products != null){
            foreach($this->products as $product){
                $product_quantity = $product->quantity()->where('order_id', $this->id)->first()->product_quantity;
                $total[] =  $product_quantity * $product->price;
            }

            if($this->discount_id != null){
                $totalPrice = array_sum($total) - (array_sum($total) * $this->discount->value);
                return $totalPrice;
            }
        }

        return array_sum($total);
    }
}
