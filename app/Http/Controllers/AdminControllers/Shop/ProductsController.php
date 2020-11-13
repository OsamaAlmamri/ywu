<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductsAttribute;
use App\Models\Shop\ShopCategory;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function __construct(Product $products)
    {

        $this->products = $products;

    }

    public function index()
    {


        if (request()->ajax()) {
            if (request()->category_id == 0)
                $data = Product::all();
            else
                $data = Product::where('category_id', 1)->get();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.products.btn.action')
                    ->addColumn('btn_image', 'admin.shop.products.btn.image')
                    ->addColumn('btn_sort', 'sortFiles.btn_sort')
                    ->addColumn('btn_status', 'admin.shop.products.btn.status')
                    ->addColumn('btn_available', 'admin.shop.products.btn.available')
                    ->rawColumns(['action', 'btn_image', 'btn_sort', 'btn_available', 'btn_status'])
                    ->make(true);
            }
        }
        $admin = Admin::where('id', 1)->first();
        return view('admin.shop.products.index', compact(['admin']));
    }

    public function attributes(Request $request)
    {
        $result = $this->products->addproductattribute($request);
//        return  dd($result['products_attributes']);
        return view('admin.shop.products.attribute.add')->with('result', $result);

    }

    public function addnewdefaultattribute(Request $request)
    {
        $products_attributes = $this->products->addnewdefaultattribute($request);
        return ($products_attributes);
    }

    public function editdefaultattribute(Request $request)
    {
        $result = $this->products->editdefaultattribute($request);
        return view("admin.shop.products.attribute.pop_up_forms.editdefaultattributeform")->with('result', $result);
    }

    public function updatedefaultattribute(Request $request)
    {
        $products_attributes = $this->products->updatedefaultattribute($request);
        return ($products_attributes);

    }

    public function deletedefaultattributemodal(Request $request)
    {

        $product_id = $request->product_id;
        $products_attributes_id = $request->products_attributes_id;
        $result['data'] = array('product_id' => $product_id, 'products_attributes_id' => $products_attributes_id);
        return view("admin.shop.products.attribute.modals.deletedefaultattributemodal")->with('result', $result);

    }

    public function deletedefaultattribute(Request $request)
    {
        $products_attributes = $this->products->deletedefaultattribute($request);
        return ($products_attributes);
    }

    public function showoptions(Request $request)
    {
        $products_attributes = $this->products->showoptions($request);
        return ($products_attributes);
    }

    public function editoptionform(Request $request)
    {
        $result = $this->products->editoptionform($request);
        return view("admin.shop.products.attribute.pop_up_forms.editproductattributeoptionform")->with('result', $result);

    }

    public function updateoption(Request $request)
    {
        $products_attributes = $this->products->updateoption($request);
        return ($products_attributes);
    }

    public function showdeletemodal(Request $request)
    {

        $product_id = $request->product_id;
        $products_attributes_id = $request->products_attributes_id;
        $result['data'] = array('product_id' => $product_id, 'products_attributes_id' => $products_attributes_id);
        return view("admin.shop.products.attribute.modals.deleteproductattributemodal")->with('result', $result);

    }

    public function deleteoption(Request $request)
    {

        $products_attributes = $this->products->deleteoption($request);
        return ($products_attributes);

    }

    public function getOptionsValue(Request $request)
    {
        $value = $this->products->getOptionsValue($request);
        if (count($value) > 0) {
            foreach ($value as $value_data) {
                $value_name[] = "<option value='" . $value_data->products_options_values_id . "'>" . $value_data->products_options_values_name . "</option>";
            }
        } else {
            $value_name = "<option value=''>" . Lang::get("labels.ChooseValue") . "</option>";
        }
        print_r($value_name);
    }


    function changeOrder(Request $request)
    {
        $sortData = Product::all();
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


    public function show($id)
    {
        $data = Product::find($id);
        return response()->json($data, 200);

    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Product::find($r->id);
        if ($r->type == 'available')
            $user->available = $new_status;
        else
            $user->status = $new_status;

        $user->save();
        return $new_status;
    }

    private function check_inputes($request)
    {
        $rules = [
            "name" => "required",
            "category_id" => 'required',
            "price" => 'required',
            "image_id" => [($request->action == 'Edit') ? 'nullable' : 'required'],

        ];
        $messages = [
            "name.required" => "يرجى اضافة اسم الصنف",
            "category_id.required" => "يرجى اختيار صنف المنتج ",
            "price.required" => "يرجى اضافة سعر المنتج ",
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

        $categoty = Product::create(array_merge($request->all(),
            [
                'space_id' => 1,
            ]));
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Product::whereId($id)->first();
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
        $categoty = Product::whereId($request->hidden_id)->first();
        $categoty = $categoty->update(array_merge($request->except('image_id'),
            [
                'image_id' => $request['image_id'] = ($request['image_id'] != null) ? $request['image_id'] : $request['old_image_id']
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
    }
}
