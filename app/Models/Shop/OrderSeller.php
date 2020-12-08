<?php

namespace App\Models\Shop;


use App\Admin;
use Illuminate\Database\Eloquent\Model;

class OrderSeller extends Model
{
    //
    public $timestamps = false;

    protected $fillable = ['order_id', 'seller_id', 'status', 'price', 'shipping_cost', 'shipping_method'
        , 'coupon_discount', 'coupon', 'new_delivery_location',
        'payment_status', 'payment_method'];

    protected $appends = ['seller_name', 'seller', 'order_status_name', 'payment_status_name'];

    function getOrderStatusNameAttribute()
    {
        $status = $this->attributes['status'];
        return trans('status.order_' . $status);
    }


    function getPaymentStatusNameAttribute()
    {
        $status = $this->attributes['payment_status'];
        return trans('status.confirm_payment_' . $status);
    }

    public function getSellerAttribute()
    {
        $s = $this->admin()->get()->first();

        $s->seller = $s->seller;
        return $s;

    }

    public function getSellerNameAttribute()
    {
        $s = $this->admin()->get()->first();
        if ($s->seller != null)
            return $s->seller->sale_name;
        return
            null;

    }

    protected $with = ['products'];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'seller_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_seller_id', 'id');
    }
}
