<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    //

//$products_attributes = DB::table('products_attributes')
//->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
//->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
////                ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
//->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
//
//->where('products_attributes.product_id', '=', $product_id)
//->orderBy('products_attributes_id', 'DESC')
//->get();

    protected $appends = ['products_options_name', 'products_options_values_name'];

    function getProductsOptionsNameAttribute()
    {
        $im = $this->product_option()->get()->first();
        return ($im != null) ? $im->products_options_name : null;
    }

    function getProductsOptionsValuesNameAttribute()
    {
        $im = $this->product_optin_value()->get()->first();
        return ($im != null) ? $im->products_options_values_name : null;
    }


    public function product_option()
    {
        return $this->belongsTo(ProductsOption::class, 'options_id', 'products_options_id');
    }

    public function product_optin_value()
    {
        return $this->belongsTo(ProductsOptionsValue::class, 'options_values_id', 'products_options_values_id');
    }

}
