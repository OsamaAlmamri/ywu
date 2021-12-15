<?php

namespace App\Models\Shop;


use App\User;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class OrderSeller2 extends Model
{
    //
    public $timestamps = false;
    protected $table = "order_sellers";
    use SoftDeletes;


    protected $fillable = ['order_id', 'seller_id', 'status', 'price', 'shipping_cost', 'shipping_method'
        , 'coupon_discount', 'coupon', 'new_delivery_location',
        'payment_status', 'payment_method'];

    protected $appends = ['order_status_name', 'payment_status_name'];

    function getOrderStatusNameAttribute()
    {
        $status = $this->attributes['status'];
        return trans('status.order_' . $status);
    }


    function getPaymentStatusNameAttribute()
    {
        $status = $this->attributes['payment_status'];
        return trans('status.payment_' . $status);
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
        return $this->belongsTo(User::class, 'seller_id', 'id');
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
