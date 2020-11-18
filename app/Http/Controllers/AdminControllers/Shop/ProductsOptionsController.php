<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\ProductsOptionsValue;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProductsOptionsController extends Controller
{
    use JsonTrait;
    use PostTrait;
    public function __construct()
    {
        $this->middleware('permission:show products_attributes', ['only' => ['index','show']]);
        $this->middleware('permission:manage products_attributes',
            ['only' => ['changeOrder', 'store_options_values','update_options_values',
                'changeOrder','update_options_values', 'destroy', 'edit', 'store', 'update', 'active']]);


    }
    public function index()
    {
        if (request()->ajax()) {
            $data = ProductsOption::with('optionsValues')->get();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.products_options.btn.action')
                    ->addColumn('products_options_values', function ($row) {
                        return view('admin.shop.products_options.btn.products_options_values')
                            ->with('row', $row);
                    })
//                    ->addColumn('products_options_values','admin.shop.products_options.btn.products_options_values' )
                    ->rawColumns(['action', 'products_options_values'])
                    ->make(true);
            }
        }
        return view('admin.shop.products_options.index');
    }

    public function show($id)
    {
        $data = ProductsOption::find($id);
        return response()->json($data, 200);

    }
    private function check_inputes($request)
    {
        $rules = [
            "products_options_name" => "required",
        ];
        $messages = [
            "name.required" => "يرجى اضافة اسم الخيار ",
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
        $categoty = ProductsOption::create($request->all());
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }

    private function check_options_values_inputes($request)
    {
        $rules = [
            "products_options_id" => "required",
            "products_options_values_name" => "required",
        ];
        $messages = [
            "name.required" => "يرجى اضافة اسم الخيار ",
        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    public function store_options_values(Request $request)
    {
        $error = $this->check_options_values_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $categoty = ProductsOptionsValue::create($request->all());
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
        $categoty = ProductsOption::find($request->hidden_id);
        $categoty = $categoty->update($request->all());
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = ProductsOption::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function update_options_values(Request $request)
    {
        $error = $this->check_options_values_inputes($request);

        if ($error->fails()) {
            return response()->json([
                'errors' => $error->errors(),
            ], 422);
        }
        $categoty = ProductsOptionsValue::find($request->hidden_id);
        $categoty = $categoty->update($request->all());
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id, $type)
    {
//        return $id;
        if ($type == 'option_value')
            $data = ProductsOptionsValue::findOrFail($id);
        else
            $data = ProductsOption::findOrFail($id);
        $data->delete();
    }
}
