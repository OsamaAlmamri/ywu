<?php

namespace App\Http\Controllers\Api\Shop;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\OrderPayment;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\OrderTiming;
use App\Models\Shop\Product;
use App\Models\Shop\ProductsAttribute;
use App\Models\Shop\OrderProductAttribute;
use App\Notifications\AppNotification;
use App\Notifications\OrderNotification;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;

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
//        return $this->ReturnErorrRespons("0000", " التسوق يبدا يوم الثلاثاء الموافق 1 ديسمبر .");

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
            $data = Cart::where([['id', '=', $request->id], ['user_id', '=', \auth()->id()]])->get()->first();
            if ($data != null) {
                $data->delete();
                return $this->GetDateResponse('data', $data, 'تم الحذف بنجاح');
            } else {
                return $this->ReturnErorrRespons('00000', $data);

            }

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function apply_coupon(Request $request, $check = 1, $co = 0)
    {
        try {
            $coupon_code = ($check == 1) ? $request->coupon : $co;
            $c = Coupon::where('coupon', $coupon_code)->get()->last();
            $c2 = Coupon::where('user_id', \auth()->id())
                ->where('used', 0)
                ->where('coupon', "!=", $coupon_code)
                ->where('order_id', null)
                ->get()->first();
            if ($c2 != null)
                $c2->update(['user_id' => null]);

            if ($c == null)
                return $this->ReturnErorrRespons('0000', "الكوبون مستخدم من قبل او منتهي الصلاحية");
            elseif ($c->used == 1 or $c->ended == 1)
                return $this->ReturnErorrRespons('0000', "الكوبون مستخدم من قبل او منتهي الصلاحية");
            elseif ($c->user_id != null and $c->user_id != \auth()->id())
                return $this->ReturnErorrRespons('0000', "هذا الكوبون مطبق من قبل احد العملاء");
            elseif ($c->user_id == \auth()->id() and $check == 1)
                return $this->ReturnErorrRespons('0000', "انت مستخدم هذا الكويون بالفعل");
            else {
                $carts = Cart::where('user_id', \auth()->id())->get();
                $total_orders = [];
                $total_sellers = [];
                $total = 0;
                foreach ($carts as $k => $cart) {
                    $gov_id = $cart->product->seller->seller->gov_id;
                    $p = $cart->product;
                    if ($gov_id == \auth()->user()->gov_id) {
                        if (array_key_exists($p->admin_id, $total_sellers))
                            $total_sellers[$p->admin_id] += $cart->quantity * $cart->price;
                        else {
                            $total_sellers[$p->admin_id] = $cart->quantity * $cart->price;
                        }
                    }
                }
                foreach ($total_sellers as $k => $total)
                    if ($total > $c->amount) {
                        $c->update(['user_id' => \auth()->id()]);
                        if ($check == 1)
                            return $this->GetDateResponse('data', $c, 'تم تطبيق الكوبون بنجاح');
                        else {
                            return $this->GetDateResponse('data', $k, 'تم تطبيق الكوبون بنجاح');

                        }

                    }
                return $this->ReturnErorrRespons('0000',
                    "يجب ان يكون مجموع السلة لمنتجات  احد تجار محافظة " . auth()->user()->gov . " اكبر من " . $c->amount);

            }


        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function delete_coupon(Request $request)
    {
        try {
            $c = Coupon::where('id', $request->id)
                ->where('user_id', \auth()->id())
                ->where('used', 0)
                ->where('order_id', null)
                ->get()->last();
            if ($c == null or $c->ended == 0)
                return $this->ReturnErorrRespons('0000', "لا يمكن حذف هذا الكوبون ");
            else {
                $c->update(['used' => 0, 'user_id' => null]);
                return $this->GetDateResponse('data', $c, 'تم حذف الكوبون بنجاح');
            }
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

    public function my_cart2(Request $request)
    {
        try {
            $data = Cart::where('user_id', '=', \auth()->id())->get();
            $coupon = Coupon::where('user_id', \auth()->id())
                ->where('used', 0)
                ->where('order_id', null)
                ->get()->last();

            return $this->GetDateResponse('data', ["coupon" => ($coupon != null and $coupon->end == 0) ? $coupon : null, "cart" => $data]);

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function cancel_order(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'order_id' => 'required|exists:order_sellers,id',
                    'description' => 'required',
                ],
                [
                    'order_id.required' => 'يرجى تحديد رقم الطلب ',
                    'description.required' => 'يرجى تحديد سبب الغاء الطلب',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            $order = OrderSeller::where('id', $request->order_id)
                ->whereExists(function ($query) {
                    $query->select("orders.id")
                        ->from('orders')
                        ->where('user_id', '=', \auth()->id())
                        ->whereRaw('order_sellers.order_id = orders.id');
                })
                ->whereNotIn('status', ['shipping', 'in_progress'])
                ->get()->first();
//            $coupon= Coupon::where()
            if ($order == null)
                return $this->ReturnErorrRespons("0000", "لا يمكن الغاء هذا الطلب الا من قبل التاجر");
            else {
                $order->status = 'cancel_by_user';
                $order->save();
                $message = ' تم الغاء الطلب رقم ' . $order->id . '  من العميل  ' . \auth()->user()->name;
                $time = OrderTiming::create(['order_seller_id' => $order->id,
                    'status' => 'cancel_by_user',
                    'description' => $request->description,
                    'type' => 'order_status'
                ]);
                $dataToNotification = array(
                    'sender_name' => auth()->user()->name,
                    'order_id' => $order->id,
                    'notification_type' => "cancel_order",
                    'user_id' => \auth()->id(),
                    'sender_image' => url('site/images/Logo250px.png'),
                    'message' => $message,
                    'date' => $time->created_at
                );
                try {
                    $order->admin->notify(new AppNotification($dataToNotification));
                    $tokens = getNotifiableUsers(0, [$order->admin->id]);
                    $this->firbaseContoller->multi($tokens, $dataToNotification);
                } catch (\Exception $ex) {
                }
                return $this->GetDateResponse('data', $order, 'تم الغاء الطلب  بنجاح');
            }
        } catch
        (\Exception $ex) {
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
                    'order_id' => 'required|exists:order_sellers,id',
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
            $o = OrderSeller::find($request->order_id);
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
                $o->admin->notify(new AppNotification($dataToNotification));
                $tokens = getNotifiableUsers(0, array_merge([$o->admin->id], $admins_id));
                $this->firbaseContoller->multi($tokens, $dataToNotification);
            } catch (\Exception $ex) {

            }
            return $this->GetDateResponse('data', $data);

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function my_orders(Request $request)
    {
        try {
            $data = Order::with(['sellers'])
                ->where('user_id', '=', \auth()->id())
                ->orderByDesc('id')
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
                $coupon = Coupon::where('user_id', \auth()->id())
                    ->where('used', 0)
                    ->where('order_id', null)
                    ->get()->last();
                $seller_coupon = 0;
                if ($coupon != null) {
                    $ch = ($this->apply_coupon($request, 0, $coupon->coupon));

                    if ($ch->original['status'] !== true)
//                        return $ch;
                        return $this->ReturnErorrRespons("0000", $ch->original['msg'] . "              قم بالغاء الكوبون او شراء ب اكثر من 5000 من نفس محافظتك                ");

                    else
                        $seller_coupon = $ch->original['data'];

                }
                $order = Order::create(
                    [
                        'user_id' => auth()->id(),
                        'gov_id' => $request->gov_id,
                        'payment_method' => ($request->payment_method=="transfer")?"transfer":"on_delivery",
                        'district_id' => $request->district_id,
                        'more_address_info' => $request->more_address_info,
                        'coupon' => ($coupon != null and $coupon->end == 0) ? $coupon->coupon : 0,
                        'coupon_discount' => ($coupon != null and $coupon->end == 0) ? $coupon->amount : 0,
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
                                'coupon' => ($coupon != null and $coupon->end == 0 and $seller_coupon == $product->admin_id) ? $coupon->coupon : 0,
                                'coupon_discount' => ($coupon != null and $coupon->end == 0 and $seller_coupon == $product->admin_id) ? $coupon->amount : 0,
                            ]);
                        $order_seller_id[$product->admin_id] = $seller->id;
                        if ($coupon != null and $coupon->end == 0 and $seller_coupon == $product->admin_id)
                            $coupon->update(['used' => 1, 'order_id' => $seller->id]);

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
                            ['order_product_id' => $order_product->id,
                                'option_name' => $att->products_options_name,
                                'option_value_name' => $att->products_options_values_name,
                            ]);
                    }
                    foreach ($sellersOrders as $k => $val) {
                        $s = OrderSeller::find($order_seller_id[$k]);
                        $message = 'طلب جديد برقم ' . $s->id . '  من العميل  ' . \auth()->user()->name;
                        $s->update([
                            'price' => $val,
                            'shipping_cost' => 0,
                        ]);
                        $time = OrderTiming::create(['order_seller_id' => $s->id,
                            'status' => 'new',
                            'description' => $message,
                            'type' => 'order_status'
                        ]);
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
