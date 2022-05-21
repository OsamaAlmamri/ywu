<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Coupon;
use App\Http\Controllers\Controller;

use App\Http\Controllers\FireBaseController;
use App\Models\Shop\Order;
use App\Models\Shop\Zone;
use App\Notifications\AppNotification;
use App\Seller;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{
    use JsonTrait;
    use PostTrait;

//    public function __construct()
//    {
////        $this->middleware('permission:show coupons', ['only' => ['index','show']]);
////        $this->middleware('permission:manage coupons', ['only' => ['changeOrder','destroy','edit','store','update','active']]);
////        $this->middleware('permission:active coupons', ['only' => ['active']]);
//    }
    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->middleware('permission:show coupons', ['only' => ['index', 'show']]);

        $this->middleware('permission:manage coupons', ['only' => ['store', 'delete_selected', 'destroy', 'update', 'update_selected']]);
        $this->firbaseContoller = $firbaseContoller;
    }


    public function index($year = "")
    {
        $year = ($year == "") ? date("Y") : $year;
        if (request()->ajax()) {

            $year = request()->year;

//coupon_used: all
//coupon_end: all
            $has_gov_id = false;
            $has_coupon_used = false;
            $has_seller = false;
            $has_coupon_end = false;
            $request = request();
            if (isset($request->gov_id) and ($request->gov_id) != "all")
                $has_gov_id = true;

            if (isset($request->coupon_used) and ($request->coupon_used) != "all")
                $has_coupon_used = true;

            if (isset($request->seller_id) and ($request->seller_id) != "all")
                $has_seller = true;

            if (isset($request->coupon_end) and ($request->coupon_end) != "all")
                $has_coupon_end = true;
            $data = Coupon::ofYear($year)->leftJoin('order_sellers', 'order_sellers.id', '=', 'coupons.order_id')
                ->leftJoin('orders', 'orders.id', '=', 'order_sellers.order_id')
                ->leftJoin('users', 'users.id', '=', 'coupons.user_id')
                ->leftJoin('zones as govs', 'orders.gov_id', '=', 'govs.id')
                ->select(['coupons.*', 'coupons.order_id as n_order_id',
                    'govs.name_ar as gov', 'govs.name_ar as gov1', 'orders.gov_id as gvv', 'order_sellers.status as order_s',
                    'users.phone as phone', 'users.name as user_name']);
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
                $data = $data->whereIn('coupons.order_id', function ($query) use ($request) {
                    $query->select('order_sellers.id')
                        ->from(with(new Order())->getTable())
                        ->from('order_sellers')
                        ->leftJoin('orders', 'order_sellers.order_id', '=', 'order_sellers.id')
                        ->where('orders.gov_id', $request->gov_id)->get();
                });
            }
            if ($has_seller) {
                $data = $data->whereIn('coupons.order_id', function ($query) use ($request) {
                    $query->select('order_sellers.id')
                        ->from('order_sellers')
                        ->where('order_sellers.seller_id', $request->seller_id)->get();
                });
            }

            $data = $data->orderBy("coupons.id", "DESC")->get();

            if ($data) {
                return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', 'admin.shop.coupons.btn.action')
                    ->addColumn('check', 'admin.shop.coupons.btn.check')
                    ->addColumn('user', 'admin.shop.coupons.btn.user')
                    ->addColumn('order_status', function ($row) {
                        return ($row->order_s != null) ? trans('status.order_' . $row->order_s) : null;
                    })
                    ->editColumn('order_id', function ($row) {
                        return ($row->n_order_id == null) ? '' : "<a class=\"btn btn-info btn-sm\" href=\"" . route('admin.shop.orders.show_seller_order', $row->n_order_id) . "\"
   style=\" margin-left: 10px;\">
    " . $row->n_order_id . "
</a>";
                    })
                    ->rawColumns(['action', 'check', 'user', 'order_id'])
                    ->make(true);
            }
        }


        $result = Coupon::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();

        $users = User::whereNotIn('type', ['customers', 'share_users', 'seller'])
            ->orderBy("id", "DESC")
            ->get(['id', 'name']);
        $years = $result->pluck('year');


        return view('admin.shop.coupons.show', compact(['years', 'year', 'users']));
    }


    public function sta($year = "")
    {
        $sum_all = Coupon::ofYear($year)->sum('amount');
        $sum_used = Coupon::ofYear($year)->where('used', '1')->sum('amount');
        $sum_unend = Coupon::ofYear($year)->where('used', '0')->where('end_date', '>', date('Y-m-d'))->sum('amount');
        $sum_end = Coupon::ofYear($year)->where('used', '0')
            ->where('end_date', '<', date('Y-m-d'))
//            ->where('ended', 1)
            ->sum('amount');

        $count_all = Coupon::ofYear($year)->count();
        $count_used = Coupon::ofYear($year)->where('used', '1')->count();
        $count_unend = Coupon::ofYear($year)->where('used', '0')
//            ->where('ended', 0)
            ->where('end_date', '>', date('Y-m-d'))
            ->count();
        $count_end = Coupon::ofYear($year)->where('used', '0')
//            ->where('ended', 1)
            ->where('end_date', '<', date('Y-m-d'))
            ->count();
        return view('admin.shop.coupons.sta', compact(['sum_all', 'sum_end', 'sum_unend', 'sum_used',
            'count_all', 'count_end', 'count_unend', 'count_used', 'year']))->render();
    }

    public function statistics($year = "")
    {
        $year = ($year == "") ? date("Y") : $year;
        if (request()->ajax()) {

            $year = request()->year;

            $year_con = ($year == 'all') ? "" : "  coupons.end_date=$year and ";


            $data = User::leftJoin('sellers', 'users.id', '=', 'sellers.admin_id')
                ->leftJoin('zones as govs', 'sellers.gov_id', '=', 'govs.id')
                ->whereIn('users.id', function ($q) {
                    $q->select('order_sellers.seller_id')->from('coupons')
                        ->leftJoin('order_sellers', 'coupons.order_id', '=', 'order_sellers.id');

//                    $q->select('order_sellers.seller_id')->from('order_sellers')
//                        ->leftJoin('coupons', 'coupons.order_id', '=', 'order_sellers.id');
                })
                ->select(['users.*', 'sellers.sale_name', 'govs.name_ar as gov1',
                    DB::raw("(SELECT count(coupons.id) FROM coupons
                                   INNER JOIN order_sellers ON order_sellers.id=coupons.order_id
                                   WHERE

                                   order_sellers.seller_id=users.id and coupons.used=1 and
                                   $year_con
                                   order_sellers.status not like 'cancel_by_seller' and
                                   order_sellers.status  not like 'cancel_by_user'
                                   ) as count_all_coupons"),
                    DB::raw("(SELECT COALESCE(sum(coupons.amount),0) FROM coupons
                                   INNER JOIN order_sellers ON order_sellers.id=coupons.order_id
                                   WHERE
                                   order_sellers.seller_id=users.id and coupons.used=1 and
                                   $year_con
                                   order_sellers.status not like 'cancel_by_seller' and
                                   order_sellers.status  not like 'cancel_by_user'
                                   ) as sum_all_coupons"),

                    DB::raw("(SELECT count(coupons.id) FROM coupons
                                   INNER JOIN order_sellers ON order_sellers.id=coupons.order_id
                                   WHERE
                                   order_sellers.seller_id=users.id and coupons.used=1 and
                                   $year_con
                                   order_sellers.status  like 'delivery'
                                   ) as count_delivery_coupons"),
                    DB::raw("(SELECT COALESCE(sum(coupons.amount),0) FROM coupons
                                   INNER JOIN order_sellers ON order_sellers.id=coupons.order_id
                                   WHERE
                                   order_sellers.seller_id=users.id and coupons.used=1 and
                                   $year_con
                                   order_sellers.status   like 'delivery'
                                   ) as  sum_delivery_coupons"),
                ]);
            if (isset(request()->gov_id) and (request()->gov_id) != "all") {
                $data = $data
                    ->where('sellers.gov_id', request()->gov_id);
            }
            $data = $data->get();
            if ($data) {
                return datatables()->of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        }

        $result = Coupon::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $years = $result->pluck('year');

        return view('admin.shop.coupons.statistics', compact(['year',
            'years']));
    }


    private
    function check_inputes($request)
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

    private
    function getUniquId()
    {
        $is_unique = true;
        while ($is_unique) {
            $confirmation_id = strtoupper(substr(md5(uniqid(rand(), true)), 2, 10));
            if (Coupon::all()->where('coupon', $confirmation_id)->count() == 0)
                return $confirmation_id;

        }
    }

    public
    function store(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        if ($request->user_id == 'all')
            $users = User::inRandomOrder()->whereIn('type', ['customers', 'visitor'])
                ->whereNotExists(function ($query) {
                    $query->select("coupons.user_id")
                        ->from('coupons')
                        ->whereRaw('users.id = coupons.user_id');
                })
                ->limit($request->number)->get();
        else
            $users = User::where('id', $request->user_id)->get();

//                if ($users->count() == 0)
//            $users = User::whereIn('type', ['customers', 'visitor'])
////                ->whereNotIn('id', function ($query) use ($request) {
////                    $query->select('user_id')
////                        ->from(with(new Coupon())->getTable());
//////                    ->where('used', 1)
//////                    ->orWhere('end_date', '>', now());
////                })
//                ->whereNotExists(function ($query) {
//                    $query->select("coupons.user_id")
//                        ->from('coupons')
//                        ->whereRaw('users.id = coupons.user_id');
//                })
//                ->limit($request->number)->get();

//        return $users;
        foreach ($users as $user) {

            if (isset($user->id)) {
                $c = Coupon::create(array_merge($request->all(),
                    [
                        'user_id' => $user->id,
                        'used' => 0,
                        'coupon' => $this->getUniquId()
                    ]));
                $message = ' لقد حصلت على كوبون تخفيض برقم  ' . $c->coupon . '  يستخدم في متاجر محافظة  ' . $user->gov;
                $dataToNotification = array(
                    'sender_name' => "اتحاد نساء اليمن",
                    'order_id' => $c->id,
                    'notification_type' => "new_coupon",
                    'user_id' => \auth()->id(),
                    'sender_image' => url('site/images/Logo250px.png'),
                    'message' => $message,
                    'date' => $c->created_at
                );
                try {
                    $user->notify(new AppNotification($dataToNotification));
                    $tokens = getNotifiableUsers($user->id, []);
                    $this->firbaseContoller->multi($tokens, $dataToNotification);
                } catch (\Exception $ex) {

                }
            }

        }
        return response()->json(['success' => 'تم اضافة ' . count($users) . ' كوبون بنجاح']);
    }

    public
    function update(Request $request)
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

    public
    function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        //$data->delete();
    }

    public
    function delete_selected(Request $request)
    {
        $data = Coupon::whereIn('id', $request->ids)->where('used', '0')->delete();
        return response()->json(['success' => 'تم الحذف  بنجاح']);

    }

    public
    function update_selected(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $data = Coupon::whereIn('id', $request->ids)->where('used', '0')
            ->update(['end_date' => $request->end_date, 'amount' => $request->amount]);
        return response()->json(['success' => 'تم التعديل  بنجاح']);

    }
}
