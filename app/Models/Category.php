<?php

namespace App\Models;

use Nestable\NestableTrait;

class Category extends \Eloquent {

    use NestableTrait;

    protected $parent = 'parent_id';

    /**
     * Get the products for categories
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'subcategory_id');
    }

}