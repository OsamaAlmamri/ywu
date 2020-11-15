<?php

namespace App\Models\Shop;


use Illuminate\Database\Eloquent\Model;

class OrderSeller extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['order_id', 'seller_id', 'status', 'price', 'shipping_cost', 'shipping_method'];
}
