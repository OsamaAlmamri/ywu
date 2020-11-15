<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\LastPosts;
use App\Like;
use App\Models\Rateable\Rating;
use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductsAttribute;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\TitleContent;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\Models\Shop\OrderProductAttribute;
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


    public function confirm_order(Request $request)
    {

        try {

            $validator = Validator::make($request->all(),
                [
                    'gov_id' => 'required|numeric',
                    'district_id' => 'required|numeric',
                    'more_address_info' => 'required',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }

            $cart_items = Cart::where('user_id', \auth()->id())->get();
            if (count($cart_items) == 0)
                return $this->ReturnErorrRespons("0000", "ليس هناك عناصر بالسلة");
            else {
                $order = Order::create(
                    [
                        'user_id' => auth()->id(),
                        'gov_id' => $request->gov_id,
                        'district_id' => $request->district_id,
                        'more_address_info' => $request->more_address_info,
                        'price' => 0,
                        'phone' => isset($request->phone) ? $request->phone : auth()->user()->phone,
                        'customer_name' => isset($request->customer_name) ? $request->customer_name : auth()->user()->name,
                    ]);
                $total = 0;
                $sellersOrders = [];
                $order_seller_id = [];
                foreach ($cart_items as $cart_item) {
                    $total += $cart_item->price;
                    $product = Product::find($cart_item->product_id);
                    if (array_key_exists($product->admin_id, $sellersOrders)) {
                        $sellersOrders[$product->admin_id] += $cart_item->price;
                    } else {
                        $sellersOrders[$product->admin_id] = $cart_item->price;
                        $seller = OrderSeller::create(
                            ['seller_id' => $product->admin_id,
                                'order_id' => $order->id,
                                'price' => 0,
                            ]);
                        $order_seller_id[$product->admin_id] = $seller->id;

                    }
                    $order_product = OrderProduct::create(
                        ['price' => $cart_item->price,
                            'attributes' => $cart_item->attributes,
                            'quantity' => $cart_item->quantity,
                            'product_id' => $cart_item->product_id,
                            'order_seller_id' => $order_seller_id[$product->admin_id],
                            'order_id' => $order->id
                        ]);
                    foreach ($cart_item->product_attributes_descriptions as $att) {
                        $att = OrderProductAttribute::create(
                            [
                                'order_product_id' => $order_product->id,
                                'option_name' => $att->products_options_name,
                                'option_value_name' => $att->products_options_values_name,
                            ]);
                    }
                    foreach ($sellersOrders as $k => $val) {
                        $s = OrderSeller::find($order_seller_id[$k]);
                        $s->update([
                            'price' => $val,
                            'shipping_cost' => 0,
                        ]);

                    }

                }
                $order->update([
                    'price' => $total
                ]);
                $order = Order::find($order->id);
                DB::table('carts')->where([
                    ['user_id', '=', \auth()->id()]])->delete();
                return $this->GetDateResponse('data', $order, 'تم اضافة الطاب  بنجاح');

            }

        } catch
        (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


}
