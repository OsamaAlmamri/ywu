<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Models\Shop\Order;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\OrderSeller2;
use App\Models\Shop\OrderTiming;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\QuestionReplay;
use App\Models\Shop\ShopCategory2;
use App\Notification;
use App\Notifications\AppNotification;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrdersController extends Controller

{

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
        $this->middleware('permission:show orders', ['only' => ['index', 'show_main_order', 'show_seller_order']]);
        $this->middleware('permission:manage orders', ['only' => ['change_sub_status', 'destroy', 'edit', 'store', 'update', 'active']]);
        $this->middleware('permission:active orders', ['only' => ['active']]);
    }

    public function index($type = 'main')
    {
        if (request()->ajax()) {
            $type = request()->type;
            $to_zone = request()->to_zone;
            $status = request()->filter_status;
            $seller_id = isset(request()->filter_seller) ? request()->filter_seller : "all";
            $payment_status = request()->payment_status;
            $from = (request()->from_date == null) ? date('1974-01-01') : date(request()->from_date);
            $to = (request()->to_date == null) ? date('9999-01-01') : date(request()->to_date);
            $data = $this->getData($type, $to_zone, $status, $payment_status, $seller_id, $from, $to);
            if ($data) {
                if ($type == 'main')
                    return datatables()->of($data)
                        ->addIndexColumn()
                        ->addColumn('action', 'admin.shop.orders.btn.action_main')
                        ->addColumn('btn_status', 'admin.shop.orders.btn.status')
                        ->rawColumns(['action', 'btn_status'])
                        ->make(true);
                else
                    return datatables()->of($data)
                        ->addIndexColumn()
                        ->addColumn('action', 'admin.shop.orders.btn.action')
                        ->addColumn('btn_status', 'admin.shop.orders.btn.status')
                        ->rawColumns(['action', 'btn_status'])
                        ->make(true);


            }
        }
        return view('admin.shop.orders.index', compact('type'));
    }

    public function getData($type, $to_zone, $status, $payment_status, $seller_id = "all", $from_date = '1970-01-01', $to_date = '9999-09-09')
    {
        if ($type == 'main') {

            $data = Order::whereBetween('created_at', [$from_date, $to_date]);
            if ($to_zone != 'all')
                $data = $data->where('gov_id', $to_zone)->orderByDesc('id');
            if ($payment_status != 'all')
                $data = $data->where('payment_status', $payment_status)->orderByDesc('id');


        } else {
//            $data = OrderSeller::with('order')
//                ->whereIn('order_id', function ($query) use ($status, $payment_status, $from_date, $to_date, $to_zone) {
//                    $query->select('id')
//                        ->from(with(new Order())->getTable())
//                        ->whereBetween('created_at', [$from_date, $to_date]);
//                    if ($to_zone != 'all')
//                        $query->where('gov_id', $to_zone);
//                    if ($payment_status != 'all')
//                        $query->where('payment_status', $payment_status);
//
//                });
            $data = OrderSeller2::leftJoin('admins', 'admins.id', '=', 'order_sellers.seller_id')
                ->leftJoin('sellers', 'admins.id', '=', 'sellers.admin_id')
                ->leftJoin('orders', 'orders.id', '=', 'order_sellers.order_id')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('zones as govs', 'orders.gov_id', '=', 'govs.id')
                ->leftJoin('zones as dis', 'orders.district_id', '=', 'dis.id')
                ->select(['order_sellers.*', 'sellers.sale_name as  seller_name', 'users.name as user_name', 'orders.more_address_info',
                    'dis.name_ar as district', 'govs.name_ar as gov',
                    DB::raw("DATE_FORMAT( orders.created_at,'" . getDBCustomDate() . "') AS published")])
                ->whereIn('order_sellers.order_id', function ($query) use ($status, $payment_status, $from_date, $to_date, $to_zone) {
                    $query->select('id')
                        ->from(with(new Order())->getTable())
                        ->whereBetween('created_at', [$from_date, $to_date]);
                    if ($to_zone != 'all')
                        $query->where('gov_id', $to_zone);
                });
//
            if ($payment_status != 'all')
                $data = $data->where('order_sellers.payment_status', $payment_status);
            if ($status != 'all')
                $data = $data->where('order_sellers.status', $status);
            if (auth()->user()->type == "admin" and $seller_id != 'all')
                $data = $data->where('seller_id', $seller_id);
            if (auth()->user()->type == "admin")
                $data = $data->orderByDesc('id');
            else
                $data = $data->where('seller_id', auth()->id())->orderByDesc('id');


        }
        $data = $data->orderByDesc('id');
        return $data;
    }

    public function show_seller_order($id)
    {
        $order_seller = OrderSeller::find($id);
        if ($order_seller == null)
            return redirect()->back();
        return view('admin.shop.orders.show')->with('type', 'sub_order')->with('order_seller', $order_seller);

    }

    public function show_main_order($id)
    {
        $order = Order::find($id);
        if ($order == null)
            return redirect()->back();
        return view('admin.shop.orders.show_main')->with('type', 'order')->with('order', $order);

    }

    public function change_sub_status(Request $request)
    {
        $rules = [
            "status" => "required",
            'description' => 'required_if:status,cancel_by_seller,min:10',
        ];
        $messages = [
            "description.required_if" => "يرجى تحديد سبب اللغاء",
            "description.min" => "يرجى تحديد سبب اللغاء",
//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }

        $order_seller = OrderSeller::find($request->order_id);
        $order_seller->status = $request->status;
        if ($order_seller->status != 'cancel_by_user' or $order_seller->status != 'cancel_by_seller')
            $order_seller->save();
        if ($request->status == 'cancel_by_seller') {
            $co = Coupon::where('coupon', $order_seller->coupon)->update(['used' => 0]);

            $message = '  تم الغاء  الطلب رقم  ' . $order_seller->id . '  من قبل متجر   ' . $order_seller->seller_name;
        } else
            $message = '  تم تغيير حالة الطلب رقم  ' . $order_seller->id . '  من قبل متجر   ' . $order_seller->seller_name;
        $time = OrderTiming::create(['order_seller_id' => $order_seller->id,
            'status' => 'new',
            'description' => $message,
            'type' => 'order_status'
        ]);

        $dataToNotification = array(
            'sender_name' => auth()->user()->seller->sale_name,
            'order_id' => $order_seller->id,
            'notification_type' => "sub_order",
            'user_id' => \auth()->id(),
            'sender_image' => url('site/images/Logo250px.png'),
            'message' => $message,
            'date' => now()
        );
        try {
            $order_seller->order->user->notify(new AppNotification($dataToNotification));
            $tokens = getNotifiableUsers(0, [$order_seller->order->user->id]);
            $this->firbaseContoller->multi($tokens, $dataToNotification);
        } catch (\Exception $ex) {
        }

        return response($order_seller, 200);
    }

    public function change_sub_status_payment(Request $request)
    {
        $rules = [
            "status" => "required",
        ];
        $messages = [
            "description.required_if" => "يرجى تحديد سبب اللغاء",
            "description.min" => "يرجى تحديد سبب اللغاء",
//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }

        $order_seller = OrderSeller::find($request->order_id);
        $order_seller->payment_status = $request->status;
        $order_seller->save();
        $message = '  تم تغيير الدفغ للطلب رقم  ' . $order_seller->id . '  من قبل متجر   ' . $order_seller->seller_name;
        $time = OrderTiming::create(['order_seller_id' => $order_seller->id,
            'status' => 'new',
            'description' => $message,
            'type' => 'payment_status'
        ]);

        return response($order_seller, 200);
    }

    public function new_delivery_location(Request $request)
    {
        $rules = [
            'new_delivery_location' => 'required|min:10',
        ];
        $messages = [
            "new_delivery_location.required" => "يرجى تحديد مكان التسليم",
            "new_delivery_location.min" => "يرجى تحديد مكان التسليم",
//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }

        $order_seller = OrderSeller::find($request->order_id);
        $order_seller->new_delivery_location = $request->new_delivery_location;
        $order_seller->save();
        $message = '  تم تحديد مكان تسليم  الطلب رقم  ' . $order_seller->id . '  من قبل متجر   ' . $order_seller->seller_name;
        $dataToNotification = array(
            'sender_name' => auth()->user()->seller->sale_name,
            'order_id' => $order_seller->id,
            'notification_type' => "sub_order",
            'user_id' => \auth()->id(),
            'sender_image' => url('site/images/Logo250px.png'),
            'message' => $message,
            'date' => now()
        );
        try {
            $order_seller->order->user->notify(new AppNotification($dataToNotification));
            $tokens = getNotifiableUsers(0, [$order_seller->order->user->id]);
            $this->firbaseContoller->multi($tokens, $dataToNotification);
        } catch (\Exception $ex) {
        }

        return response($order_seller, 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        {
            foreach ($order->sellers as $seller) {

                $result = Notification::where('data->order_id', $seller->id)->delete();
            }
        }

//        $order->sellers->delete();
        OrderSeller::where('order_id', $id)->delete();
        $result = Notification::where('data->order_id', $order->id)->delete();
        $order->delete();


    }

}
