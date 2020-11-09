<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category;
use App\Models\Shop\ShopCategory;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\Question;
use App\Result;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {

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
        $admin = Admin::where('id', 1)->first();
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
        $data->delete();
    }
}
