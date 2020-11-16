<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    //
    protected $fillable = ['admin_id', 'order_id', 'user_id', 'invoice_number', 'status', 'amount', 'note'];

}
