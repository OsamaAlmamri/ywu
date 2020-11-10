<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductsOption;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsOptionsController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
        if (request()->ajax()) {
            $data = ProductsOption::all();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.products_options.btn.action')
                    ->addColumn('products_options_values', 'admin.shop.products_options.btn.products_options_values')
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


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = ProductsOption::whereId($id)->first();
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
        $categoty = ProductsOption::whereId($request->hidden_id)->first();
        $categoty = $categoty->update($request->all());
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = ProductsOption::findOrFail($id);
        $data->delete();
    }
}
