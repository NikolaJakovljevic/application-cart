<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'table_id', 'id')->where('status', 0);
    }
}
