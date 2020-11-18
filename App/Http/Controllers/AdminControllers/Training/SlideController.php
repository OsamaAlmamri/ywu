<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Admin;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\Question;
use App\Result;
use App\Slide;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SlideController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function __construct()
    {
        $this->middleware('permission:show slides', ['only' => ['index','show','changeType']]);
        $this->middleware('permission:manage slides', ['only' => ['changeType','changeOrder','destroy','edit','store','update','active']]);
        $this->middleware('permission:active slides', ['only' => ['active']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $post = Slide::orderBy('sort')->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', 'admin.training.slides.btn.action')
                    ->addColumn('btn_image', 'admin.training.slides.btn.image')
                    ->addColumn('btn_sort', 'sortFiles.btn_sort')
                    ->addColumn('btn_status', 'admin.training.slides.btn.status')
                    ->rawColumns(['btn_sort', 'action', 'btn_image', 'btn_status'])
                    ->make(true);
            }
        }
        $admin = Admin::where('id', 1)->first();
        return view('admin.training.slides.show', compact(['admin']));
    }

    public
    function changeOrder(Request $request)
    {
        $sortData = Slide::all();
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

    public
    function changeType(Request $request)
    {
        $ids = "";
        if ($request->type == 'trainings') {
            $data = Training::all();
            foreach ($data as $element) {
                $ids.="<option value='".$element->id."'>".$element->name." </option>" ;

            }
        } elseif ($request->type == 'women') {
            $data = WomenPosts::all();
            foreach ($data as $element) {
                $ids.="<option value='".$element->id."'>".$element->title." </option>" ;
            }

        } else {
            $data = Post::all()->where('status', 1);
            foreach ($data as $element) {
                $ids.="<option value='".$element->id."'>".$element->title." </option>" ;
            }


        }
        return response()->json($ids,200);
    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Slide::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }


    private function check_inputes($request)
    {
        $rules = [
            "description" => "required",
            "image" => [($request->action == 'Edit') ? 'nullable' : 'required', 'image'],
        ];
        $messages = [
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
        $silde = Slide::create(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Slide::whereId($id)->first();
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
        $silde = Slide::whereId($request->hidden_id)->first();
        $image = $this->Post_update($request, 'image', "IMG-", 'assets/images', $silde->image);
        $silde = $silde->update(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = Slide::findOrFail($id);
        $data->delete();
    }
}
