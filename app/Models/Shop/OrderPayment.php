<?php

namespace App\Models\Shop;

use App\Admin;
use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    //
    protected $fillable = ['admin_id', 'order_id', 'user_id', 'invoice_number', 'status', 'amount', 'note'];
    protected $appends = ['admin_name', 'user_name', 'status_name'];

    function getStatusNameAttribute()
    {
        $status = $this->attributes['status'];
        return trans('status.confirm_payment_' . $status);
    }

    public function getAdminNameAttribute()
    {
        $s = $this->admin()->get()->first();
        return ($s != null) ? $s->name : null;
    }

    public function getUserNameAttribute()
    {
        $s = $this->admin()->get()->first();
        return ($s != null) ? $s->name : "تم حذف العميل";
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(OrderSeller::class, 'order_id', 'id');
    }

}
