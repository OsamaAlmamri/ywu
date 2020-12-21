<?php

namespace App;

use App\Models\Shop\OrderProduct;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'status', 'phone', 'email', 'image', 'password'
    ];
    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public function seller()
    {
        return $this->hasOne(Seller::class, 'admin_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'admin_id', 'id');

    }

    public function order_products()
    {
        return $this->hasMany(OrderSeller::class, 'seller_id', 'id');

    }

}
