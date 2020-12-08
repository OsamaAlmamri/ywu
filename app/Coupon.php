<?php

namespace App;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //      $table->string('coupon')->unique();
    //            $table->integer('amount')->default(5000);
    //            $table->boolean('used')->default(0);
    //            $table->unsignedBigInteger('order_id')->nullable();
    //            $table->date('end_date');
    protected $fillable = ['coupon', 'amount', 'used', 'user_id', 'order_id', 'end_date'];


    protected $appends = ['ended', 'user_name', 'gov','phone'];

    function getGovAttribute()
    {
        $im = $this->order()->get()->first();
        return ($im != null) ? $im->gov : null;
    }

    function getUserNameAttribute()
    {
        $im = $this->user()->get()->first();
        return ($im != null) ? $im->name : null;
    }

    function getPhoneAttribute()
    {
        $im = $this->user()->get()->first();
        return ($im != null) ? $im->phone : null;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getEndedAttribute()
    {
        $now = now();
        $nowSecode = strtotime($now);
        $end_date = strtotime($this->attributes['end_date']);
        $can = ($nowSecode - $end_date) > 0 ? true : false;
        return $can;
    }
}
