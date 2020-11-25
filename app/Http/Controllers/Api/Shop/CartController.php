<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Http\Resources\LastPosts;
use App\Like;
use App\Models\Rateable\Rating;
use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\OrderPayment;
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
use App\Notifications\AppNotification;
use App\Notifications\OrderNotification;
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

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
    }


    public function add_to_cart(Request $request)
    {
        return $this->ReturnErorrRespons("0000", " التسوق يبدا يوم الثلاثاء الموافق 1 ديسمبر .");

        $this->customer = Auth::user();
        try {
            $product = Product::find($request['product_id']);
            $price = $product->price;
            $attributes = "";
            $add = 0;
            $olds = Cart::where('product_id', $request['product_id'])
                ->where('user_id', \auth()->id())->get();
            foreach ($olds as $old) {
                if ($product->has_attribute == 0 and $olds->count() > 0) {
                    $add = 1;
                }
                $old_att = array_map('intval', explode(',', $old->attributes));
                if (isset($request['product_attributes'])) {
                    $result = array_diff($old_att, $request['product_attributes']);
                    if (count($result) == 0)
                        $add = 1;
                } else {
                    $add = 1;
                }

            }
            if ($add == 1)
                return $this->GetDateResponse('data', 0, ' هذا المنتج مضاف مسبقا');
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

    public function my_cart(Request $request)
    {
        try {
            $data = Cart::where('user_id', '=', \auth()->id())->get();
            return $this->GetDateResponse('data', $data);

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function add_payment(Request $request)
    {
        try {
//            'order_id', 'user_id', 'invoice_number', 'status', 'amount',
//            return
//            return $this->ReturnErorrRespons('$ex->getCode()',  \auth()->id());

            $validator = Validator::make($request->all(),
                [
                    'order_id' => 'required|exists:orders,id',
                    'invoice_number' => 'required|numeric',
                    'amount' => 'required|numeric',
                ],
                [
                    'order_id.required' => 'يرجى تحديد رقم الطلب ',
                    'invoice_number.required' => 'يرجى تحديد رقم الحوالة ',
                    'amount.required' => 'يرجى تحديد مبلغ الحوالة'
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            $data = OrderPayment::create(array_merge($request->all(), ['status' => 1, 'user_id' => auth()->id()]));
            $o = Order::find($request->order_id);
            $o->payment_status = 1;
            $o->save();
            $message = ' تم اضافة تكاليف الطلب رقم ' . $request->order_id . '  من العميل  ' . \auth()->user()->name;
            $dataToNotification = array(
                'sender_name' => auth()->user()->name,
                'order_id' => $request->order_id,
                'notification_type' => "payment",
                'user_id' => \auth()->id(),
                'sender_image' => url('site/images/Logo250px.png'),
                'message' => $message,
                'date' => $data->created_at
            );
            try {
                $admins_id = [];
                $admins = getAdminsOrderNotifucation('new_payment');
                foreach ($admins as $admin) {
                    $admins_id[] = $admin->id;
                    $admin->notify(new AppNotification($dataToNotification));
                }
                $tokens = getNotifiableUsers(0, $admins_id);
                $this->firbaseContoller->multi($tokens, $dataToNotification);
                return $this->GetDateResponse('data', $data);
            } catch (\Exception $ex) {

            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function my_orders(Request $request)
    {
        try {
            $data = Order::with(['sellers'])
                ->where('user_id', '=', \auth()->id())
                ->paginate(100);
            return $this->GetDateResponse('data', $data);

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
//            return $this->ReturnErorrRespons("0000", "سيبدا التسوق قريبا بتاريخ 25 نوفمبر ");

            if (count($cart_items) == 0)
                return $this->ReturnErorrRespons("0000", "ليس هناك عناصر بالسلة");
            else {
                $total_order_price = 0;
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
                    $total += ($cart_item->quantity * $cart_item->price);
                    $total_order_price += ($cart_item->quantity * $cart_item->price);
                    $product = Product::find($cart_item->product_id);
                    if (array_key_exists($product->admin_id, $sellersOrders)) {
                        $sellersOrders[$product->admin_id] += ($cart_item->quantity * $cart_item->price);
                    } else {
                        $sellersOrders[$product->admin_id] = ($cart_item->quantity * $cart_item->price);
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
                        $message = 'طلب جديد برقم ' . $s->id . '  من العميل  ' . \auth()->user()->name;
                        $dataToNotification = array(
                            'sender_name' => auth()->user()->name,
                            'order_id' => $s->id,
                            'notification_type' => "sub_order",
                            'user_id' => \auth()->id(),
                            'sender_image' => url('site/images/Logo250px.png'),
                            'message' => $message,
                            'date' => $order->created_at
                        );
                        $s->admin->notify(new AppNotification($dataToNotification));
                        try {
                            $tokens = getNotifiableUsers(0, [$s->admin->id]);
                            $this->firbaseContoller->multi($tokens, $dataToNotification);
                        } catch (\Exception $ex) {
                        }
                    }

                }

                $order = Order::find($order->id);
                $order->update([
                    'price' => $total_order_price
                ]);

                DB::table('carts')->where([
                    ['user_id', '=', \auth()->id()]])->delete();
                $message = 'طلب جديد برقم ' . $order->id . '  من العميل  ' . \auth()->user()->name;

                $dataToNotification = array(
                    'sender_name' => auth()->user()->name,
                    'order_id' => $order->id,
                    'notification_type' => "order",
                    'user_id' => \auth()->id(),
                    'sender_image' => url('site/images/Logo250px.png'),
                    'message' => $message,
                    'date' => $order->created_at
                );
                try {
                    $admins_id = [];
                    $admins = getAdminsOrderNotifucation('new_order');
                    foreach ($admins as $admin) {
                        $admins_id[] = $admin->id;
                        $admin->notify(new AppNotification($dataToNotification));
                    }
                    $tokens = getNotifiableUsers(0, $admins_id);
                    $this->firbaseContoller->multi($tokens, $dataToNotification);
                } catch (\Exception $ex) {

                }
                return $this->GetDateResponse('data', $order, 'تم اضافة الطاب  بنجاح');

            }

        } catch
        (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


}
