<?php

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['space_id', 'category_id', 'name', 'description', 'image_id', 'price', 'has_attribute', 'available', 'sort', 'status'];

    protected $appends = ['image','published', 'image_actual', 'zone','category','space'];



    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    function getImageAttribute()
    {
        $im = $this->image_category_th();
        return ($im != null) ? $this->image_category_th()->path : null;
    }

    function getZoneAttribute()
    {
        $im = $this->space();
        return ($im != null) ? $this->space()->zone : null;
    }
    function getSpaceAttribute()
    {
        $im = $this->space();
        return ($im != null) ? $this->space()->name : null;
    }
    function getCategoryAttribute()
    {
        $im = $this->category();
        return ($im != null) ? $this->category()->name : null;
    }

    public function space()
    {
        return $this->belongsTo(Space::class, 'space_id', 'id')
            ->first();
    }
    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id', 'id')
            ->first();
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
