<?php

namespace App\Models\Shop;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ShopCategory2 extends Model
{
    //
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $table = 'shop_categories';
    protected $fillable = ['name', 'status', 'sort', 'image_id'];
    protected $appends = ['image'];

    function getImageAttribute()
    {
        $im = $this->image_category_th();
        return ($im != null) ? $this->image_category_th()->path : null;
    }

    function getImageActualAttribute()
    {
        $im = $this->image_category_act();
        return ($im != null) ? $this->image_category_act()->path : null;
    }

    public function image_category_th()
    {
        return $this->belongsTo(ImageCategory::class, 'image_id', 'image_id')
            ->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'THUMBNAIL');
            })->first();
    }

    public function image_category_act()
    {
        return $this->belongsTo(ImageCategory::class, 'image_id', 'image_id')
            ->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'ACTUAL');
            })->first();
    }


    public function products()
    {
        return $this->hasMany(Product2::class, 'category_id', 'id')
            ->whereIn('products.admin_id', function ($query) {
                $query->select('id')
                    ->from(with(new User())->getTable())
                    ->where('deleted_at', null)
                    ->where('status', '=', 1);
            });
    }
}
