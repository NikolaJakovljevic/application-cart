<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const FEATURED = 1;
    const ACTIVE = 1;

    public function quantity()
    {
        return $this->hasOne('App\Models\OrderProduct', 'product_id', 'id');
    }

    public function scopeFeatured($query, $param)
    {
        return $query->where('featured', $param);
    }

    public function scopeActive($query, $param)
    {
        return $query->where('active', $param);
    }
}
