<?php

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //
    protected $fillable = ['admin_id', 'category_id', 'name', 'description', 'image_id', 'price', 'has_attribute', 'available', 'sort', 'status'];

    protected $appends = ['image', 'image_actual', 'published', 'zone', 'category', 'space'];


    public function defaults_attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'product_id', 'id')
            ->where('is_default', 1);
    }

    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
//
//    public function addproductattribute($request)
//    {
//        $product_id = $request->id;
//        $subcategory_id = $request->subcategory_id;
//        $options = DB::table('products_options')->get();
//        $result['options'] = $options;
//        $result['subcategory_id'] = $subcategory_id;
//        $options_value = DB::table('products_options_values')->get();
//        $result['options_value'] = $options_value;
//        $result['data'] = array('product_id' => $product_id);
//        $products_attributes = DB::table('products_attributes')
//            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
//            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//            ->select('products_attributes.*')
//            ->where('products_attributes.product_id', '=', $product_id)
//            ->orderBy('products_attributes_id', 'DESC')
//            ->get();
//        $result['products_attributes'] = $products_attributes;
//        return $result;

//    }

    public function addproductattribute($request)
    {
        $product_id = $request->id;
        $subcategory_id = $request->subcategory_id;
        $options = DB::table('products_options')
            ->get();
        $result['options'] = $options;
        $result['subcategory_id'] = $subcategory_id;
        $options_value = DB::table('products_options_values')->get();
        $result['options_value'] = $options_value;
        $result['data'] = array('product_id' => $product_id);

        $result['products_attributes'] = $this->products_attributes($product_id);

        return $result;
    }

    public function products_attributes($product_id = 0)
    {
//        if ($product_id != null)
        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//                ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->where('products_attributes.product_id', '=', $product_id)
            ->orderBy('products_attributes_id', 'DESC')
            ->get();

        return $products_attributes;
    }

    public function addnewdefaultattribute($request)
    {
        $language_id = 1;
        $products_attributes = '';
        if (!empty($request->products_options_id) and !empty($request->product_id) and !empty($request->products_options_values_id)) {
            $checkRecord = DB::table('products_attributes')->where([
                'options_id' => $request->products_options_id,
                'product_id' => $request->product_id,
                'options_values_id' => $request->products_options_values_id,
            ])->get();
            if (count($checkRecord) > 0) {
                $products_attributes = 'already';
            } else {
                $products_attributes_id = DB::table('products_attributes')->insertGetId([
                    'product_id' => $request->product_id,
                    'options_id' => $request->products_options_id,
                    'options_values_id' => $request->products_options_values_id,
                    'options_values_price' => '0',
                    'price_prefix' => '+',
                    'is_default' => $request->is_default
                ]);
                $products_attributes = DB::table('products_attributes')
                    ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                    ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//                    ->select('products_attributes.*', 'products_options_values_name')
                    ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
                    ->where('products_attributes.product_id', '=', $request->product_id)
                    ->where('products_attributes.is_default', '=', '1')
                    ->orderBy('products_attributes_id', 'DESC')
                    ->get();
            }
        } else {
            $products_attributes = 'empty';
        }

        return $products_attributes;
    }

    public function editdefaultattribute($request)
    {


        $products_attributes_id = $request->products_attributes_id;
        $options_id = $request->options_id;
        $options = DB::table('products_options')
            ->select('products_options.products_options_id', 'products_options_name')
            ->get();
        $result['options'] = $options;
        $options_value = DB::table('products_options_values')
            ->select('products_options_values.products_options_values_id', 'products_options_values_name')
            ->where('products_options_values.products_options_id', '=', $options_id)
            ->get();
        $result['options_value'] = $options_value;
        $result['data'] = array('product_id' => $request->product_id, 'products_attributes_id' => $products_attributes_id);

        $result['products_attributes'] = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->where('products_attributes.products_attributes_id', '=', $products_attributes_id)
            ->get();
        return $result;
    }

    public function updatedefaultattribute($request)
    {

        if (!empty($request->products_options_id) and !empty($request->product_id) and !empty($request->products_options_values_id)) {
            $checkRecord = DB::table('products_attributes')->where([
                'options_id' => $request->products_options_id,
                'options_values_id' => $request->products_options_values_id,
                'product_id' => $request->product_id
            ])->get();
            $productsattri = DB::table('products_attributes')->where('products_attributes_id', '=', $request->products_attributes_id)->update([
                'options_id' => $request->products_options_id,
                'options_values_id' => $request->products_options_values_id,
                'options_values_price' => 0,
                'price_prefix' => '+',

            ]);
            $products_attributes = DB::table('products_attributes')
                ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//                ->select('products_attributes.*', 'products_options_name', 'products_options_values_name')

                ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
                ->where('products_attributes.product_id', '=', $request->product_id)
                ->where('products_attributes.is_default', '=', '1')
                ->orderBy('products_attributes_id', 'DESC')
                ->get();
        } else {
            $products_attributes = 'empty';
        }
        return $products_attributes;
    }

    public function deletedefaultattribute($request)
    {
        $checkRecord = DB::table('products_attributes')->where([
            'products_attributes_id' => $request->products_attributes_id,
            'product_id' => $request->product_id
        ])->delete();
        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//            ->select('products_attributes.*', 'products_options_name', 'products_options_values_name')
            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->where('products_attributes.product_id', '=', $request->product_id)
            ->where('products_attributes.is_default', '=', '1')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();
        return $products_attributes;
    }

    public function showoptions($request)
    {
        if (!empty($request->products_options_id) and !empty($request->product_id) and !empty($request->products_options_values_id) and isset($request->options_values_price)) {
            $checkRecord = DB::table('products_attributes')->where([
                'options_id' => $request->products_options_id,
                'options_values_id' => $request->products_options_values_id,
                'product_id' => $request->product_id
            ])->get();
            if (count($checkRecord) > 0) {
                $products_attributes = '';
            } else {
                $language_id = 1;
                $products_attributes_id = DB::table('products_attributes')->insertGetId([
                    'product_id' => $request->product_id,
                    'options_id' => $request->products_options_id,
                    'options_values_id' => $request->products_options_values_id,
                    'options_values_price' => $request->options_values_price,
                    'price_prefix' => $request->price_prefix,
                    'is_default' => $request->is_default
                ]);
                $products_attributes = DB::table('products_attributes')
                    ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                    ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//                    ->select('products_attributes.*', 'products_options_name', 'products_options_values_name')
                    ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
                    ->where('products_attributes.is_default', '=', '0')
                    ->orderBy('products_attributes_id', 'DESC')
                    ->get();
            }
        } else {
            $products_attributes = 'empty';
        }

        return $products_attributes;
    }

    public function editoptionform($request)
    {

        $product_id = $request->product_id;
        $products_attributes_id = $request->products_attributes_id;
        $language_id = $request->language_id;
        $options_id = $request->options_id;

        $product_id = $request->product_id;
        $products_attributes_id = $request->products_attributes_id;
        $language_id = 1;
        $options_id = $request->options_id;
        $options = DB::table('products_options')
            ->select('products_options.products_options_id', 'products_options_name')
            ->get();
        $result['options'] = $options;
        $options_value = DB::table('products_options_values')
            ->select('products_options_values.products_options_values_id', 'products_options_values_name')
            ->where('products_options_values.products_options_id', '=', $options_id)
            ->get();
        $result['options_value'] = $options_value;
        $result['data'] = array('product_id' => $request->product_id, 'products_attributes_id' => $products_attributes_id);

        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//            ->select('products_attributes.*', 'products_options_name', 'products_options_values_name')
            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->where('products_attributes.products_attributes_id', '=', $products_attributes_id)
            ->get();;
        $result['products_attributes'] = $products_attributes;
        return $result;
    }

    public function updateoption($request)
    {

        $checkRecord = DB::table('products_attributes')->where([
            'options_id' => $request->products_options_id,
            'options_values_id' => $request->products_options_values_id,
            'product_id' => $request->product_id
        ])->get();
        DB::table('products_attributes')->where('products_attributes_id', '=', $request->products_attributes_id)->update([
            'options_id' => $request->products_options_id,
            'options_values_id' => $request->products_options_values_id,
            'options_values_price' => $request->options_values_price,
            'price_prefix' => $request->price_prefix,
        ]);
        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//            ->select('products_attributes.*', 'products_options_name', 'products_options_values_name')
            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->where('products_attributes.product_id', '=', $request->product_id)
            ->where('products_attributes.is_default', '=', '0')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();
        return $products_attributes;
    }

    public function deleteoption($request)
    {
        $checkRecord = DB::table('products_attributes')->where([
            'products_attributes_id' => $request->products_attributes_id,
            'product_id' => $request->product_id
        ])->delete();
        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
//            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->select('products_attributes.*', 'products_options.products_options_name', 'products_options_values.products_options_values_name')
            ->where('products_attributes.product_id', '=', $request->product_id)
            ->where('products_attributes.is_default', '=', '0')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();

        return $products_attributes;
    }

    public function getOptionsValue($request)
    {
        $value = DB::table('products_options_values')
            ->select('products_options_values.*')
            ->where('products_options_values.products_options_id', '=', $request->option_id)
            ->get();
        return $value;
    }


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
        return $this->belongsTo(Space::class, 'admin_id', 'id')
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

    function getProductOptionsAttribute()
    {
        $data = [];
        $ids = [];
        $im = $this->attributes()->get();
        foreach ($im as $option) {
            if (!in_array($option->options_id, $ids)) {
                $ids[] = $option->options_id;
                $values = [];
                foreach ($im as $value) {
                    if ($value->options_id == $option->options_id)
                        $values[] = array(
                            'products_attributes_id' => $option->products_attributes_id,
                            'options_values_id' => $value->options_values_id,
                            'products_options_values_name' => $value->products_options_values_name,
                            'price' => $value->options_values_price,
                            'price_prefix' => $value->price_prefix,
                            'is_default' => $value->is_default,
                        );
                }
                $data[] = array(
                    'options_id' => $option->options_id,
                    'products_options_name' => $option->products_options_name,
                    'values' => $values
                );
            }
        }

        return $data;
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
