<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['price', 'user_id', 'gov_id', 'district_id', 'more_address_info', 'phone', 'customer_name'];
}
