<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Coupon;
use App\Http\Controllers\Controller;

use App\Models\Shop\Order;
use App\Models\Shop\Zone;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function __construct()
    {
//        $this->middleware('permission:show coupons', ['only' => ['index','show']]);
//        $this->middleware('permission:manage coupons', ['only' => ['changeOrder','destroy','edit','store','update','active']]);
//        $this->middleware('permission:active coupons', ['only' => ['active']]);
    }


    public function index()
    {
        if (request()->ajax()) {
//coupon_used: all
//coupon_end: all
            $has_gov_id = false;
            $has_coupon_used = false;
            $has_coupon_end = false;
            $request = request();
            if (isset($request->gov_id) and ($request->gov_id) != "all")
                $has_gov_id = true;

            if (isset($request->coupon_used) and ($request->coupon_used) != "all")
                $has_coupon_used = true;

            if (isset($request->coupon_end) and ($request->coupon_end) != "all")
                $has_coupon_end = true;

            $data = Coupon::where('id', '>', 0);
            if ($has_coupon_used) {
                $data = $data->where('used', $request->coupon_used);
            }
            if ($has_coupon_end) {
                if ($request->coupon_end == 1)
                    $data = $data->where('end_date', '<', now());
                else
                    $data = $data->where('end_date', '>', now());
            }
            if ($has_gov_id) {
                $data = $data->whereIn('order_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from(with(new Order())->getTable())
                        ->where('gov_id', $request->gov_id)->get();
                });
            }
            $data = $data->get();

            if ($data) {
                return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', 'admin.shop.coupons.btn.action')
                    ->addColumn('check', 'admin.shop.coupons.btn.check')
                    ->rawColumns(['action', 'check'])
                    ->make(true);
            }
        }
        return view('admin.shop.coupons.show');
    }

    private function check_inputes($request)
    {
        $rules = [
            "amount" => "required",
            "end_date" => "required",
//            "number" => "required",
        ];
        $messages = [
            "amount.required" => "يرجى تحديد مبلغ الكوبون",
            "end_date.required" => "يرجى تحديد تاريخ صلاحية الكوبونات",
            "number.required" => "يرجى تحديد عدد االكوبونات المطلو انشائها",
//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    private function getUniquId()
    {
        $is_unique = true;
        while ($is_unique) {
            $confirmation_id = strtoupper(substr(md5(uniqid(rand(), true)), 2, 10));
            if (Coupon::all()->where('coupon', $confirmation_id)->count() == 0)
                return $confirmation_id;

        }
    }

    public function store(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        for ($i = 0; $i < $request->number; $i++) {
            $categoty = Coupon::create(array_merge($request->all(),
                [
                    'used' => 0,
                    'coupon' => $this->getUniquId()
                ]));
        }


        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }

    public function update(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $categoty = Coupon::whereId($request->hidden_id)->first();
        $categoty = $categoty->update(array_merge($request->except('image_id'),
            [
                'image_id' => $request['image_id'] = ($request['image_id'] != null) ? $request['image_id'] : $request['old_image_id']
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        $data->delete();
    }

    public function delete_selected(Request $request)
    {
        $data = Coupon::whereIn('id', $request->ids)->where('used', '0')->delete();
    }

    public function update_selected(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $data = Coupon::whereIn('id', $request->ids)->where('used', '0')
            ->update(['end_date' => $request->end_date, 'amount' => $request->amount]);

    }
}
