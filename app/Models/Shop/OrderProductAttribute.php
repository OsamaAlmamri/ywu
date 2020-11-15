<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderProductAttribute extends Model
{
    public $timestamps=false;

    //
    protected $fillable = ['order_product_id', 'option_value_name', 'option_name'];
}
