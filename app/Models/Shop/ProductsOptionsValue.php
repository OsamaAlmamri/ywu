<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductsOptionsValue extends Model
{
    //
    protected $primaryKey = 'products_options_values_id';
    protected $fillable = ['products_options_id', 'products_options_values_name'];
}
