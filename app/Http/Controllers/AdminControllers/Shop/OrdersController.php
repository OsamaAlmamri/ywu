<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Models\Shop\Order;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\QuestionReplay;
use App\Notifications\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class OrdersController extends Controller

{

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
        $this->middleware('permission:show orders', ['only' => ['index','show_main_order','show_seller_order']]);
        $this->middleware('permission:manage orders', ['only' => ['change_sub_status','destroy','edit','store','update','active']]);
        $this->middleware('permission:active orders', ['only' => ['active']]);
    }

    public function index($type = 'main')
    {
        if (request()->ajax()) {
            $type = request()->type;
            $to_zone = request()->to_zone;
            $status = request()->status;
            $payment_status = request()->payment_status;
            $from = (request()->from_date == null) ? date('1974-01-01') : date(request()->from_date);
            $to = (request()->to_date == null) ? date('9999-01-01') : date(request()->to_date);
            $data = $this->getData($type, $to_zone, $status, $payment_status, $from, $to);
            if ($data) {
                if ($type == 'main')
                    return datatables()->of($data)
                        ->addColumn('action', 'admin.shop.orders.btn.action_main')
                        ->addColumn('btn_status', 'admin.shop.orders.btn.status')
                        ->rawColumns(['action', 'btn_status'])
                        ->make(true);
                else
                    return datatables()->of($data)
                        ->addColumn('action', 'admin.shop.orders.btn.action')
                        ->addColumn('btn_status', 'admin.shop.orders.btn.status')
                        ->rawColumns(['action', 'btn_status'])
                        ->make(true);


            }
        }
        return view('admin.shop.orders.index', compact('type'));
    }
    public function getData($type, $to_zone, $status, $payment_status, $from_date = '1970-01-01', $to_date = '9999-09-09')
    {
        if ($type == 'main') {

            $data = Order::whereBetween('created_at', [$from_date, $to_date]);
            if ($to_zone != 'all')
                $data = $data->where('gov_id', $to_zone);
            if ($payment_status != 'all')
                $data = $data->where('payment_status', $payment_status);

        } else {
            $data = OrderSeller::with('order')
                ->whereIn('order_id', function ($query) use ($status, $payment_status, $from_date, $to_date, $to_zone) {
                    $query->select('id')
                        ->from(with(new Order())->getTable())
                        ->whereBetween('created_at', [$from_date, $to_date]);
                    if ($to_zone != 'all')
                        $query->where('gov_id', $to_zone);
                    if ($payment_status != 'all')
                        $query->where('payment_status', $payment_status);

                })->where('seller_id', auth()->id());
//            if ($status != 'all')
//                $data = $data->where('status', $status);

        }

        return $data->get();
    }
    public function show_seller_order($id)
    {
        $order_seller = OrderSeller::find($id);
        return view('admin.shop.orders.show')->with('type', 'sub_order')->with('order_seller', $order_seller);

    }
    public function show_main_order($id)
    {
        $order = Order::find($id);
        return view('admin.shop.orders.show_main')->with('type', 'order')->with('order', $order);

    }
    public function change_sub_status(Request $request)
    {

        $order_seller = OrderSeller::find($request->order_id);
        $order_seller->status = $request->status;
        $order_seller->save();

        $message = '  تم تغيير حالة الطلب رقم  ' . $order_seller->id . '  من قبل متجر   ' . $order_seller->seller_name;
        $dataToNotification = array(
            'sender_name' => auth()->user()->name,
            'order_id' => $order_seller->id,
            'notification_type' => "sub_order",
            'user_id' => \auth()->id(),
            'sender_image' => url('site/images/Logo250px.png'),
            'message' => $message,
            'date' => now()
        );
        $order_seller->order->user->notify(new AppNotification($dataToNotification));
        $tokens = getNotifiableUsers(0, [$order_seller->order->user->id]);
        $this->firbaseContoller->multi($tokens, $dataToNotification);

        return response($order_seller, 200);
    }


}
