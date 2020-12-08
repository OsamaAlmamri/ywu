<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Models\Shop\Order;
use App\Models\Shop\OrderPayment;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\QuestionReplay;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PaymentController extends Controller

{
    public function __construct()
    {
        $this->middleware('permission:show payment', ['only' => ['index',]]);
        $this->middleware('permission:manage payment', ['only' => ['change_status', 'destroy', 'edit', 'store', 'update', 'active']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $payment_status = request()->payment_status;
            $from = (request()->from_date == null) ? date('1974-01-01') : date(request()->from_date);
            $to = (request()->to_date == null) ? date('9999-01-01') : date(request()->to_date);
            $data = $this->getData($payment_status, $from, $to);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', 'admin.shop.payments.btn.action')
                ->addColumn('btn_status', 'admin.shop.payments.btn.status')
                ->addColumn('btn_order_status', 'admin.shop.payments.btn.order_status')
                ->rawColumns(['btn_order_status', 'action', 'btn_status'])
                ->make(true);


        }
        return view('admin.shop.payments.index');
    }

    public function getData($payment_status, $from_date = '1970-01-01', $to_date = '9999-09-09')
    {
        $data = OrderPayment::with('order')
            ->whereBetween('created_at', [$from_date, $to_date]);

        if ($payment_status != "all") {
            $data = $data->where('status', $payment_status);
        }
        return $data->orderByDesc('id')->get();
    }

    public
    function change_status(Request $request)
    {
        if ($request->type == "change_order_payment") {
            $order = OrderSeller::find($request->type_id);
            $order->payment_status = 2;
            $order->save();
        } else {
            $order_payment = OrderPayment::find($request->type_id);
            $order_payment->status = 2;
            $order_payment->admin_id = auth()->id();

            $order_payment->save();
            if ($request->with_order == 1) {
                $order = OrderSeller::find($order_payment->order_id);
                $order->payment_status = 2;
                $order->save();
            }

        }

        return response('Update Successfully.', 200);
    }


}
