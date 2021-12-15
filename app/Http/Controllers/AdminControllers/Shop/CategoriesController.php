<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\Product;
use App\Models\Shop\ShopCategory;

use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function __construct()
    {
        $this->middleware('permission:show categories', ['only' => ['index', 'show']]);
        $this->middleware('permission:manage categories', ['only' => ['changeOrder', 'destroy', 'edit', 'store', 'update', 'active']]);
        $this->middleware('permission:active categories', ['only' => ['active']]);
    }

    public function index()
    {


//        $pr = OrderProduct::create(['price' => 2000, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 121, 'order_id' => 121]);
//        $pr2 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 121, 'order_id' => 121]);
//
//        $pr3 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 115, 'order_id' => 115]);
//        $pr4 = OrderProduct::create(['price' => 2500, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 115, 'order_id' => 115]);
//
//
//        $pr5 = OrderProduct::create(['price' => 2000, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 109, 'order_id' => 109]);
//        $pr6 = OrderProduct::create(['price' => 2500, 'quantity' => 1, 'product_id' => 769, 'order_seller_id' => 109, 'order_id' => 109]);
//
//
//        $pr7 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 101, 'order_id' => 101]);
//        $pr8 = OrderProduct::create(['price' => 2000, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 101, 'order_id' => 101]);
//
//        $pr9 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 87, 'order_id' => 87]);
//
//        $pr10 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 55, 'order_id' => 55]);
//
//        $pr11 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 142, 'order_id' => 142]);
//        $pr3 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 142, 'order_id' => 142]);
//        $pr4 = OrderProduct::create(['price' => 2500, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 142, 'order_id' => 142]);
//        /*////*/
//
//        $pr = OrderProduct::create(['price' => 2000, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 129, 'order_id' => 129]);
//        $pr2 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 129, 'order_id' => 129]);
//
//
//        $pr = OrderProduct::create(['price' => 2000, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 118, 'order_id' => 118]);
//        $pr2 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 118, 'order_id' => 118]);
//
//        $pr3 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 116, 'order_id' => 116]);
//        $pr4 = OrderProduct::create(['price' => 2500, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 116, 'order_id' => 116]);
//
//        $pr3 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 113, 'order_id' => 113]);
//
//
//        $pr7 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 110, 'order_id' => 110]);
//        $pr8 = OrderProduct::create(['price' => 2000, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 110, 'order_id' => 110]);
//
//
//        $pr2 = OrderProduct::create(['price' => 3000, 'quantity' => 1, 'product_id' => 767, 'order_seller_id' => 123, 'order_id' => 123]);
//
//        $pr3 = OrderProduct::create(['price' => 4000, 'quantity' => 1, 'product_id' => 770, 'order_seller_id' => 123, 'order_id' => 123]);
//        $pr4 = OrderProduct::create(['price' => 2500, 'quantity' => 1, 'product_id' => 768, 'order_seller_id' => 123, 'order_id' => 123]);

        if (request()->ajax()) {
            $data = ShopCategory::orderBy('sort')->get();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.categories.btn.action')
                    ->addColumn('btn_image', 'admin.shop.categories.btn.image')
                    ->addColumn('btn_sort', 'sortFiles.btn_sort')
                    ->addColumn('btn_status', 'admin.shop.categories.btn.status')
                    ->rawColumns(['btn_sort', 'action', 'btn_image', 'btn_status'])
                    ->make(true);
            }
        }
        $admin = User::where('id', 1)->first();
        return view('admin.shop.categories.show', compact(['admin']));
    }

    public
    function changeOrder(Request $request)
    {
        $sortData = ShopCategory::all();
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

    public function show()
    {

    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = ShopCategory::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }

    private function check_inputes($request)
    {
        $rules = [
            "name" => "required",
            "image_id" => [($request->action == 'Edit') ? 'nullable' : 'required'],
        ];
        $messages = [
            "name.required" => "يرجى اضافة اسم الصنف",
            "image_id.required" => "يرجى اختيار صورة اولا ",
//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    public function store(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $image = $this->Post_Save($request, 'image', "IMG-", 'assets/images');
        $categoty = ShopCategory::create(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = ShopCategory::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $error = $this->check_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $categoty = ShopCategory::whereId($request->hidden_id)->first();
        $categoty = $categoty->update(array_merge($request->except('image_id'),
            [
                'image_id' => $request['image_id'] = ($request['image_id'] != null) ? $request['image_id'] : $request['old_image_id']
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = ShopCategory::findOrFail($id);
        $c = Product::all()->where('category_id', $id)->count();
        if ($c == 0) {
            $data->delete();
            return response()->json(['success' => 'تم الحذف  بنجاح']);

        } else
            return response()->json(['success' => 'لا يمكن حذف هذا المنتج لوجود منتجات  مرتبطة بة ']);
    }
}
