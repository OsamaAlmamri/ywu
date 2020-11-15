<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    public $timestamps=false;
    protected $fillable=['price','attributes','quantity','product_id','order_seller_id','order_id'];
}
