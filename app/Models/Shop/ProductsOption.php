<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductsOption extends Model
{
    public $timestamps=false;

    //
    protected $primaryKey = 'products_options_id';
    protected $fillable = ['products_options_name'];

//ProductsOptionsValue

public function optionsValues ()
{
    return $this->hasMany(ProductsOptionsValue::class,'products_options_id','products_options_id');
}


}
