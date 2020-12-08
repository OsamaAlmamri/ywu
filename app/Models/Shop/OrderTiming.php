<?php

namespace App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class OrderTiming extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_seller_id', 'status', 'description', 'type'
    ];
    //order_status_name

    protected $appends = ['status_name', 'published'];


    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    function getOrderStatusNameAttribute()
    {
        $status = $this->attributes['type'];
        return ($status == 'payment_status') ? trans('status.confirm_payment_' . $status)
            : trans('status.order_' . $status);
    }
}
