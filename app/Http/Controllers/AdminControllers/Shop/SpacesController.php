<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Space;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpacesController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {

        if (request()->ajax()) {
            if (request()->zone_id == 0)
                $data = Space::all();
            else
                $data = Space::where('zone_id', request()->zone_id)->get();

            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.spaces.btn.action')
                    ->addColumn('btn_status', 'admin.shop.spaces.btn.status')
                    ->rawColumns(['action', 'btn_status'])
                    ->make(true);
            }
        }
        $admin = Admin::where('id', 1)->first();
        return view('admin.shop.spaces.index', compact(['admin']));
    }


    public function show($id)
    {
        $data = Space::find($id);
        return response()->json($data, 200);

    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Space::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }


    private function check_inputes($request)
    {
        $rules = [
            "name" => "required",
            "zone_id" => 'required',
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
        $categoty = Space::create(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Space::whereId($id)->first();
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
        $categoty = Space::whereId($request->hidden_id)->first();
        $categoty = $categoty->update(array_merge($request->except('image_id'),
            [
                'image_id' => $request['image_id'] = ($request['image_id'] != null) ? $request['image_id'] : $request['old_image_id']
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = Space::findOrFail($id);
        $data->delete();
    }
}
