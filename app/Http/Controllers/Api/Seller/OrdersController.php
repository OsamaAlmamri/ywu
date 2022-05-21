<?php

namespace App\Http\Controllers\Api\Seller;

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
use App\Traits\JsonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrdersController extends Controller

{    protected $user;
    use JsonTrait;

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;

    }

    public function index(Request $request)
    {
        $to_zone = (!isset($request->to_zone) or ($request->to_zone == null)) ? "all" : $request->to_zone;
        $status = (!isset($request->filter_status) or ($request->filter_status == null) )? "all" : $request->filter_status;
        $payment_status =(! isset($request->payment_status) or ($request->payment_status == null)) ? "all" : $request->payment_status;
        $from = (!isset($request->from_date) or ($request->from_date == null) )? date('1974-01-01') : date($request->from_date);
        $to = (!(isset($request->to_date) or $request->to_date == null)) ? date('9999-01-01' ): date($request->to_date);

        $data = OrderSeller2::leftJoin('admins', 'admins.id', '=', 'order_sellers.seller_id')
            ->leftJoin('sellers', 'admins.id', '=', 'sellers.admin_id')
            ->leftJoin('orders', 'orders.id', '=', 'order_sellers.order_id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('zones as govs', 'orders.gov_id', '=', 'govs.id')
            ->leftJoin('zones as dis', 'orders.district_id', '=', 'dis.id')
            ->select(['order_sellers.*', 'sellers.sale_name as  seller_name', 'users.name as user_name', 'orders.more_address_info',
                'dis.name_ar as district', 'govs.name_ar as gov',
                DB::raw("DATE_FORMAT( orders.created_at,'" . getDBCustomDate() . "') AS published")])

            ->whereIn('order_sellers.order_id', function ($query) use ($status, $payment_status, $from, $to, $to_zone) {
                $query->select('id')
                    ->from(with(new Order())->getTable());
//                    ->whereBetween('created_at', [$from, $to]);
                if ($to_zone != 'all')
                    $query->where('gov_id', $to_zone);
            });
        if ($payment_status != 'all')
            $data = $data->where('order_sellers.payment_status', $payment_status);
        if ($status != 'all')
            $data = $data->where('order_sellers.status', $status);

        $data = $data
            ->where('seller_id', auth()->id())
            ->orderByDesc('id')->paginate(10);

        return $this->GetDateResponse('data', $data);

    }

    public function show_seller_order(Request $request)
    {
        $order_seller = OrderSeller::find($request->id);
        return $this->GetDateResponse('data', $order_seller);
    }

    public function change_sub_status(Request $request)
    {
        $rules = [
            "order_id" => "required",
            "status" => "required",
            'description' => 'required_if:status,cancel_by_seller,min:10',
        ];
        $messages = [
            "description.required_if" => "يرجى تحديد سبب اللغاء",
            "description.min" => " سبب اللغاء يجب ان يكون على الاقل 10 احرف",

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
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
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }

        return $this->GetDateResponse('data', $order_seller);
    }

    public function new_delivery_location(Request $request)
    {
        $rules = [
            "order_id" => "required",
            'new_delivery_location' => 'required|min:10',
        ];
        $messages = [
            "new_delivery_location.required" => "يرجى تحديد مكان التسليم",
            "new_delivery_location.min" => "يرجى تحديد مكان التسليم",
//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
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
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }

        return $this->GetDateResponse('data', $order_seller);


    }
}
