<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['price', 'attributes', 'quantity', 'product_id', 'order_seller_id', 'order_id'];

    protected $appends = ['product_attributes', 'product_attributes_descriptions'];

    public function getProductAttributesAttribute()
    {
        return array_map('intval', explode(',', $this->attributes['attributes']));

    }

    public function getProductAttributesDescriptionsAttribute()
    {
        $att = array_map('intval', explode(',', $this->attributes['attributes']));
        return ProductsAttribute::whereIn('products_attributes_id', $att)->get();
    }
}
