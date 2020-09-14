<?php

namespace App\Http\Controllers;

use App\Activaty;
use App\Admin;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Question;
use App\Result;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivitiesController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
        if (request()->ajax()) {
            $post = Activaty::orderBy('sort')->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', 'activates.btn.action')
                    ->addColumn('btn_image', 'activates.btn.image')
                    ->addColumn('btn_sort', 'sortFiles.btn_sort')
                    ->addColumn('btn_status', 'activates.btn.status')
                    ->rawColumns(['btn_sort', 'action', 'btn_image','btn_status'])
                    ->make(true);
            }
        }
        $admin = Admin::where('id', 1)->first();
        return view('activates.show', compact(['admin']));
    }

    public
    function changeOrder(Request $request)
    {
        $sortData = Activaty::all();
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

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Activaty::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }


    private function check_inputes($request)
    {
        $rules = [
            "title" => "required",
            "description" => "required",
            "image" => [($request->action == 'Edit') ? 'nullable' : 'required', 'image'],
        ];
        $messages = [
            "title.required" => "يرجى كتابة العنوان",
            "description.required" => "يرجى كتابة الوصف",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

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
        $silde = Activaty::create(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Activaty::whereId($id)->first();
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
        $silde = Activaty::whereId($request->hidden_id)->first();
        $image = $this->Post_update($request, 'image', "IMG-", 'assets/images', $silde->image);
        $silde = $silde->update(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = Activaty::findOrFail($id);
        $data->delete();
    }
}
