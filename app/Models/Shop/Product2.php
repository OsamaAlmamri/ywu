<?php

namespace App\Models\Shop;

use App\User;
use App\Like;
use App\Models\Rateable\Rateable;
use App\Models\Rateable\Rating;
use App\Models\TrainingContents\Training;
use App\Seller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product2 extends Model
{
    //
    use SoftDeletes;
    protected $table = 'products';
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    use  Rateable;

    protected $fillable = ['admin_id', 'category_id', 'name', 'description', 'image_id', 'price', 'has_attribute', 'available', 'sort', 'status'];
    protected $with = ['is_like'];
    protected $appends = ['image'];

//    protected $with = ['admin'];

    function getPercentRatingAttribute()
    {
        return $this->ratingPercent();
    }

    public function is_like()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(Like::class, 'liked_id', 'id')
            ->where('type', 'product')
            ->where('user_id', $user_id);
    }

    public function productCart()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(Cart::class, 'product_id', 'id')
            ->where('user_id', $user_id);
    }


    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    function getAverageRatingAttribute()
    {
        return round($this->averageRating(), 1);
    }


    function getCountRatingAttribute()
    {
        return $this->countRating();
    }

    public function is_rating()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(Rating::class, 'rateable_id', 'id')
            ->where('rateable_type', Product::class)
            ->where('user_id', $user_id);
    }

    public function defaults_attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'product_id', 'id')
            ->where('is_default', 1);
    }

    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'product_id', 'id');
    }

    function product_questions()
    {
        return $this->hasMany(ProductQuestion::class, 'product_id', 'id')->orderByDesc('id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    function getImageAttribute()
    {
        $im = $this->image_category_lrg();
        if ($im != null)
            return $this->image_category_lrg()->path;

        else {
            $im = $this->image_category_act();
            return ($im != null) ? $this->image_category_act()->path : $this->image_category_th()->path;

        }

    }

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

    public function space()
    {
        return $this->hasOne(Seller::class, 'admin_id', 'id')
            ->first();
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id', 'id')
            ->first();
    }


    public function image_category_th()
    {
        return $this->belongsTo(ImageCategory::class, 'image_id', 'image_id')
            ->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'THUMBNAIL');
            })->first();


    }

    public function image_category_lrg()
    {
        return $this->belongsTo(ImageCategory::class, 'image_id', 'image_id')
            ->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'LARGE');
            })->first();


    }

    public function image_category_med()
    {
        return $this->belongsTo(ImageCategory::class, 'image_id', 'image_id')
            ->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'MEDIUM');
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
