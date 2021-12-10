<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Coupon;
use App\Http\Controllers\Controller;

use App\Admin;
use App\Employee;
use App\Models\Shop\Order;
use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use App\Models\Shop\ShopCategory;
use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\Training;
use App\Models\UserContents\Category;
use App\Models\UserContents\Comment;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\Seller;
use App\ShareUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->type == "admin") {
            $shareduser = User::all()->where('type', 'share_users')->where('status', 1)->count();
            $admin = Admin::where('id', 1)->first();
            $users = User::all()->whereIn('type', ['customers', 'visitor'])->count();
            $employees = Employee::all()->count();
            $subjects = Subject::all()->count();
            $trainings = Training::all()->count();
            $pos = Post::all()->count();
            $pos_agree = Post::all()->where('status', true)->count();
            $women = WomenPosts::all()->count();
            $soft_delete = Post::onlyTrashed()->count();
            $posts = Post::with(['user', 'category'])->where('status', false)->orderBy('id', 'desc')->paginate(5);

            /*****************/
            $products = Product::all()->count();
            $shopCategory = ShopCategory::all()->count();
            $seller = Admin::all()->where('type', 'seller')->count();
            $all_orders = Order::all()->count();
            $all_payment_orders = Order::all()->where('payment_status', 1)->count();
            $all_no_payment_orders = Order::all()->where('payment_status', 0)->count();
            $all__no_payment_orders = OrderSeller::all()->count();
            $new_orders = OrderSeller::all()->where('status', "new")->count();
            $deliver_orders = OrderSeller::all()->where('status', "delivery")->count();
            $cancel_orders = OrderSeller::all()->whereIn('status', ['cancel_by_seller', 'cancel_by_user'])->count();
            $coupons = Coupon::all()->count();
            $coupons_used = Coupon::all()->where('used', 1)->count();
            $coupons_not_used = Coupon::all()->where('used', 0)->count();

            return view('admin.training.asking.index', compact(['products', 'new_orders', 'deliver_orders', 'shopCategory', 'seller', 'all_orders', 'all_payment_orders', 'all_no_payment_orders'
                , "cancel_orders", "coupons", "coupons_used", "coupons_not_used", 'shareduser', 'admin', 'trainings', 'subjects', 'posts', 'soft_delete', 'pos_agree', 'users', 'pos', 'employees', 'women']));
        } else {

            $admin_id = auth()->id();
            $products = Product::all()->where('admin_id', $admin_id)->count();
            $all_orders = OrderSeller::all()->where('seller_id', $admin_id)->count();
            $new_orders = OrderSeller::all()->where('seller_id', $admin_id)->where('status', "new")->count();
            $deliver_orders = OrderSeller::all()->where('seller_id', $admin_id)->where('status', "delivery")->count();

            return view('admin.training.asking.seller_index', compact(['products', 'all_orders', 'new_orders', 'deliver_orders']));
        }
    }

    public
    function restore(Request $request)
    {
        if ($request->id) {
            Post::where('id', $request->id)->restore();
            return response()->json(['id' => $request->id]);
        }
    }

    public
    function force(Request $request)
    {
        if ($request->id) {
            Post::where('id', $request->id)->forceDelete($request->id);
            return response()->json(['id' => $request->id]);
        }
    }

    public
    function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['status' => true, 'message' => "تم رفض العناصر بنجاح."]);
    }

    public
    function forceMultiple(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->forceDelete($request->id);
        return response()->json(['status' => true, 'message' => "تم حذف العناصر بنجاح."]);
    }

    public
    function restoreMultiple(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->restore();
        return response()->json(['status' => true, 'message' => "تم استعادة العناصر بنجاح."]);
    }

    public
    function update_multi(Request $request)
    {
        $ids = $request->ids;
        $post = Post::whereIn('id', explode(",", $ids));
        if ($post) {
            $post->update(['status' => true]);
            return response()->json(['status' => true, 'message' => "تم موافقة العناصر بنجاح."]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطاؤ ',
            ]);
        }
    }


    public
    function show()
    {

        $posts = Post::with(['user', 'category'])
            ->where('status', true);
        if (request()->category != null)
            $posts = $posts->where('category_id', request()->category);
        if (request()->user != null)
            $posts = $posts->where('user_id', request()->user);
        if (request()->type != null) {
            if (request()->type == "re_publish")
                $posts = $posts->whereNotNull('original_post_id');
            elseif (request()->type == "not_re_publish")
                $posts = $posts->whereNull('original_post_id');
            elseif (request()->type == "public")
                $posts = $posts->where('is_public', 1);
            elseif (request()->type == "private")
                $posts = $posts->where('is_public', 0);

        }
        $posts = $posts->orderBy('id', 'desc')->paginate(5);
        $comments = Comment::with(['user', 'post'])->get();
        $categories = Category::all();
        $users = User::withTrashed()->get();
        $admin = Admin::where('id', 1)->first();
        return view('admin.training.asking.show', compact(['admin', 'posts', 'comments', 'categories', 'users']));

    }

    function fetch(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with(['user', 'category'])
                ->where('status', false)
                ->orderBy('id', 'desc')
                ->paginate(5);
            $admin = Admin::where('id', 1)->first();
            return view('admin.training.asking.fetch', compact(['posts', 'admin']))->render();
        }
    }

    function editConsultant($id)
    {

        $type = "edit";
        $post = Post::where('original_post_id', $id)->get()->first();
        if ($post == null) {
            $post = Post::find($id);
            $type = "new";
        }
        return response()->json([
            'status' => true,
            'data' => $post,
            'type' => $type,
        ]);
    }


    public function rePublish(Request $request)
    {
        try {
            $rules = [
                "title" => "required",
                "body" => "required",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if ($request->action == 'new') {
                $old = Post::find($request->hidden_id);
                $post = Post::create([
                    'title' => $request->title,
                    'body' => $request->body,
                    "category_id" => $old->category_id,
                    "original_post_id" => $old->id,
                    'status' => 1,
                    'is_public' => 1,
                    'user_id' => auth()->id(),
                ]);
            } else {
                $old = Post::find($request->hidden_id);
                $post = $old->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'user_id' => auth()->id(),
                ]);
            }

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }

    }


    #################################################
    public
    function update(Request $request)
    {
        $post = Post::with('user')->find($request->id);
        if (empty($post->user->name)) {
            return response()->json([
                'status' => false,
                'mag' => 'لايمكن قبول منشورات',
                'id' => $request->id,
            ]);
        } else {
            if ($post) {
                $post->status = true;
                $post->update();
                return response()->json([
                    'status' => true,
                    'mag' => 'تم الحذف بنجاح',
                    'id' => $request->id,
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'حدث خطاؤ ',
                ]);
            }
        }
    }

    public
    function destroy(Request $request)
    {
        if ($request->id) {
            Post::destroy(request('id'));
            return response()->json([
                'status' => true,
                'mag' => 'تم الرفض',
                'id' => $request->id,
            ]);
            //return response()->json(['id'=>$request->id]);
        }
    }

    function deletedPost(Request $request)
    {
        $soft_delete = Post::onlyTrashed()->with(['user', 'category'])->orderBy('id', 'desc')->paginate(5);
        $admin = Admin::where('id', 1)->first();
        return view('admin.training.asking.trashed', compact(['soft_delete', 'admin']))->render();
    }

    public
    function comment_D(Request $request)
    {
        if ($request->id) {
            Comment::destroy(request('id'));
            return response()->json([
                'status' => true,
                'mag' => 'تم الحذف',
                'id' => $request->id,
            ]);
        }
    }
}
