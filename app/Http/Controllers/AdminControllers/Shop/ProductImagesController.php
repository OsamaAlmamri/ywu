<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductImage;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductImagesController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index($id)
    {
        if (request()->ajax()) {
            $data = ProductImage::where('product_id', $id)->orderBy('sort')->get();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.products.images.btn.action')
                    ->addColumn('btn_image', 'admin.shop.products.images.btn.image')
                    ->addColumn('btn_sort', 'sortFiles.btn_sort')
                    ->rawColumns(['btn_sort', 'action', 'btn_image'])
                    ->make(true);
            }
        }
        $product=Product::find($id);
        return view('admin.shop.products.images.show', compact(['product']));
    }

    public
    function changeOrder(Request $request)
    {
        $sortData = ProductImage::all();
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


    private function check_inputes($request)
    {
        $rules = [
            "image_id" => [($request->action == 'Edit') ? 'nullable' : 'required'],
        ];
        $messages = [
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
        $categoty = ProductImage::create($request->all());
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = ProductImage::whereId($id)->first();
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
        $categoty = ProductImage::whereId($request->hidden_id)->first();
        $categoty = $categoty->update(array_merge($request->except('image_id'),
            [
                'image_id' => $request['image_id'] = ($request['image_id'] != null) ? $request['image_id'] : $request['old_image_id']
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = ProductImage::findOrFail($id);
        $data->delete();
    }
}
