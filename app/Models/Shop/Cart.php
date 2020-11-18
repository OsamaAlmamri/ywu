<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = ['product_id', 'user_id', 'quantity', 'attributes', 'price'];
    protected $appends = ['product_attributes', 'product_attributes_descriptions'];
    protected $with = ['product'];

    public function getProductAttributesAttribute()
    {
        return array_map('intval', explode(',', $this->attributes['attributes']));

    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getProductAttributesDescriptionsAttribute()
    {
        $att = array_map('intval', explode(',', $this->attributes['attributes']));
        return ProductsAttribute::whereIn('products_attributes_id', $att)->get();
    }

}
