<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductsOption extends Model
{
    //
    protected $primaryKey = 'products_options_id';
    protected $fillable = ['products_options_name'];

}
