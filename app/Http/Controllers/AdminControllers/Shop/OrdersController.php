<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\QuestionReplay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class OrdersController extends Controller

{
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

                });
//            if ($status != 'all')
//                $data = $data->where('status', $status);

        }

        return $data->get();
    }

    public function show_seller_order($id)
    {
      $order_seller=  OrderSeller::find($id);
        return view('admin.shop.orders.show')->with('type', 'sub_order')->with('order_seller',$order_seller);

    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = ProductQuestion::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }

    public function replay_orders(Request $request)
    {
        $dada = array(
            'product_question_id' => $request->ques_ques_id,
            'text' => $request->reply,
            'replay_user_id' => auth()->user()->id,
            'replay_user_type' => 'admin',
        );
        if ($request->ques_ques_replay_id == 0)
            $replay = QuestionReplay::create($dada);
        else {
            $replay = QuestionReplay::find($request->ques_ques_replay_id);
            $replay->update($dada);
        }
        return response($replay, 200);
    }

    public function delete_replay(Request $request)
    {

        $replay = QuestionReplay::find($request->reply_id)->delete();

        return response($replay == true ? 1 : 0, 200);
    }

    public function edit_orders($id, $status)
    {
        $pro = ProductsOption::find($id);
        if ($status == 1)
            $pro->update(['status' => 1, 'question_read' => 1]);
        elseif ($status == 0)
            $pro->update(['question_read' => 1]);
        else
            $pro->update(['status' => 0, 'question_read' => 1]);
        $message = Lang::get("labels.product_question_updateMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public
    function changeOrder(Request $request)
    {
        $sortData = ProductQuestion::all();
        foreach ($sortData as $element) {
            $element->timestamps = false; // To disable update_at field updation
            $id = $element->id;
            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $element->update(['sort' => $order['position']]);
                }
            }
        }
        return response('Update Successfully.', 200);
    }


    public function show_replies($id)
    {
        $productQuestion = ProductQuestion::find($id);
        return view("admin.shop.orders.show")
            ->with('productQuestion', $productQuestion);

    }


}
