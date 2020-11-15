<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\LastPosts;
use App\Like;
use App\Models\Rateable\Rating;
use App\Models\Shop\Cart;
use App\Models\Shop\Product;
use App\Models\Shop\ProductsAttribute;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\TitleContent;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\Question;
use App\Result;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\UserTraining;
use App\UserTrainingTiltle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $customer;
    protected $other;
    use JsonTrait;
    use PostTrait;


    public function add_to_cart(Request $request)
    {
        return Cart::all();
        $this->customer = Auth::user();
        try {
            $product = Product::find($request['product_id']);
            $price = $product->price;
            $attributes = "";
            $add = 0;
            $olds = Cart::where('product_id', $request['product_id'])
                ->where('user_id', \auth()->id())->get();
            foreach ($olds as $old) {
                $old_att = array_map('intval', explode(',', $old->attributes));
                $result = array_diff($old_att, $request['product_attributes']);
                if (count($result) == 0)
                    $add = 1;
            }
            if ($add == 1)
                return $this->ReturnErorrRespons('0000', ' هذا المنتج مضاف مسبقا');
            if (isset($request['product_attributes'])) {
                $attributes = implode(',', $request['product_attributes']);
                $products_attributes = ProductsAttribute::whereIn('products_attributes_id', $request['product_attributes'])->get();
                foreach ($products_attributes as $att) {
                    if ($att->is_default == 0)
                        if ($att->price_prefix == '+')
                            $price += $att->options_values_price;
                        else
                            $price -= $att->options_values_price;
                }
            }
            $item = Cart::create(
                ['product_id' => $product->id,
                    'user_id' => \auth()->id(),
                    'quantity' => $request['quantity'],
                    'attributes' => $attributes,
                    'price' => $price
                ]);
            return $this->GetDateResponse('data', $item, 'تم اضافة المنتج بنجاح');


        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function delete_from_cart(Request $request)
    {
        try {
            DB::table('carts')->where([['id', '=', $request->id],
                ['user_id', '=', \auth()->id()]])->delete();
            return $this->GetDateResponse('data', '', 'تم الحذف بنجاح');

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function update_cart(Request $request)
    {
        $this->customer = Auth::user();
        try {
            DB::table('carts')->where([
                ['user_id', '=', \auth()->id()]])->delete();

            foreach ($request['cart_items'] as $cart_item) {
//                return $cart_item['product_id'];
                $product = Product::find($cart_item['product_id']);
                $price = $product->price;
                $attributes = "";
                if (isset($cart_item['product_attributes'])) {
                    $attributes = implode(',', $cart_item['product_attributes']);
                    $products_attributes = ProductsAttribute::whereIn('products_attributes_id',
                        $cart_item['product_attributes'])->get();
                    foreach ($products_attributes as $att) {
                        if ($att->is_default == 0)
                            if ($att->price_prefix == '+')
                                $price += $att->options_values_price;
                            else
                                $price -= $att->options_values_price;
                    }
                }
                $item = Cart::create(
                    ['product_id' => $product->id,
                        'user_id' => \auth()->id(),
                        'quantity' => $cart_item['quantity'],
                        'attributes' => $attributes,
                        'price' => $price
                    ]);
            }
            $total = 0;
            $items = Cart::where('user_id', \auth()->id())->get();
            foreach ($items as $item) {
                $total += ($item->quantity * $item->price);
            }
            return $this->GetDateResponse('data', ['total' => $total, 'cart_items' => $items], 'تم تحديث السلة بنجاح');


        } catch
        (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


}
