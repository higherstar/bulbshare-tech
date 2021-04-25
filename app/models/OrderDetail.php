<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $table = 'order_details';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
