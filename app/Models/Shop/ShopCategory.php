<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    //
    protected $fillable = ['name', 'status', 'sort', 'image_id'];
    protected $appends = ['image', 'image_actual'];

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
}
