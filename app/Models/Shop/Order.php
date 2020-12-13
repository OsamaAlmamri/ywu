<?php

namespace App\Models\Shop;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['coupon','coupon_discount','price', 'payment_method', 'payment_status', 'user_id', 'gov_id', 'district_id', 'more_address_info', 'phone', 'customer_name'];
    protected $appends = ['published', 'district', 'gov', 'user_name', 'payment_status_name'];


    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    function getPaymentStatusNameAttribute()
    {
        $status = $this->attributes['payment_status'];
        return trans('status.confirm_payment_' . $status);
    }


    function getDistrictAttribute()
    {
        $im = $this->district()->get()->first();
        return ($im != null) ? $im->name_ar : null;
    }


    function getUserNameAttribute()
    {
        $im = $this->user()->get()->first();
        return ($im != null) ? $im->name : null;
    }

    function getGovAttribute()
    {
        $im = $this->gov()->get()->first();
        return ($im != null) ? $im->name_ar : null;
    }


    public function gov()
    {
        return $this->belongsTo(Zone::class, 'gov_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(Zone::class, 'district_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function sellers()
    {
        return $this->hasMany(OrderSeller::class, 'order_id', 'id');
    }
}
