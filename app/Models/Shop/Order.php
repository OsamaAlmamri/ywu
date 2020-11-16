<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['price', 'user_id', 'gov_id', 'district_id', 'more_address_info', 'phone', 'customer_name'];
    protected $appends = ['district', 'gov'];

    function getDistrictAttribute()
    {
        $im = $this->district()->get()->first();
        return ($im != null) ? $im->name_ar : null;
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
