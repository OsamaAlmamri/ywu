<?php

namespace App\Http\Controllers\AdminControllers\Training;
use App\Http\Controllers\Controller;

use App\Activaty;
use App\Admin;
use App\Category_Training;
use App\Department;
use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\Training;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    use JsonTrait;
    use PostTrait;
    public function __construct()
    {
        $this->middleware('permission:show training', ['only' => ['index','show']]);
        $this->middleware('permission:manage training', ['only' => ['index_trashed','show_trashed','restore_post','force','changeOrder','destroy','edit','store','update','active']]);
        $this->middleware('permission:active training', ['only' => ['active']]);
    }

    public function index()
    {
//        $training = Training::orderByDesc('id')->get();
//        return dd($training);
        if (request()->ajax()) {
            if (!empty(request()->filter_country))
                $training = Training::with('category')
                    ->where('category_id', request()->filter_country)->orderByDesc('id')->get();
            else
                $training = Training::with('category')->orderByDesc('id')->get();
            return datatables()->of($training)
                ->addColumn('content', 'admin.training.training.btn.content')
                ->addColumn('action', 'admin.training.training.btn.action')
                ->addColumn('btn_image', 'admin.training.training.btn.image')
                ->addColumn('btn_mark', 'admin.training.training.btn.btn_mark')
                ->editColumn('subject', function ($training) {
                    return empty($training->category) ? 'No producent' : $training->category->name;
                })
                ->rawColumns(['action', 'btn_mark', 'btn_image', 'content'])
                ->make(true);
        }
        $categories = SubjectCategory::all();
        $departments = Department::all();
        $admin = Admin::where('id', 1)->first();
        return view('admin.training.training.index', compact(['departments', 'categories', 'admin']));
    }

    public
    function create()
    {
        //
    }


    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Training::find($r->id);
        if ($r->type == 'mark')
            $user->mark = $new_status;
        else
            $user->mark = $new_status;
        $user->save();
        return $new_status;
    }


    public
    function store(Request $request)
    {
        $rules = [
            "name" => "required",
            "length" => "nullable",
            "start_at" => "nullable",
            "end_at" => "nullable",
            "image" => "required|mimes:jpg,png,jpeg,gif,svg",
        ];
        $messages = [
            "name.required" => "يرجى كتابة عنوان الدورة",
            "image.required" => "يرجى ارفاق صورة توضيحية للدورة",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new Training();
        $post->name = $request->name;
        $post->type = $request->type;
        $post->category_id = $request->category_id;
        $post->length = $request->length;
        $post->start_at = $request->start_at;
        $post->end_at = $request->end_at;
        $post->description = $request->description;
        $post->has_certificate = $request->has_certificate;
        $post->learn = $request->learn;
        $post->instructor = $request->instructor;
        $post->thumbnail = $this->Post_Save($request, 'image', "IMG-", 'assets/images');

        $post->save();
        $departments = Department::find($request->departments);
        $post->departments()->sync($departments);

        if ($post->save())
            return response()->json(['success' => 'تم النشر بنجاح']);
    }

    public
    function show($id)
    {
        if (request()->ajax()) {
            $data = Training::with(['subject', 'titles'])->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public
    function edit($id)
    {
        if (request()->ajax()) {
            $data = Training::with('departments')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public
    function update(Request $request)
    {
        $rules = [
            "name" => "required",
            "mark" => "nullable",
            "length" => "nullable",
            "start_at" => "nullable",
            "end_at" => "nullable",
//            "image" => "required|mimes:jpg,png,jpeg,gif,svg",
        ];
        $messages = [
            "name.required" => "يرجى كتابة عنوان الدورة",
            "image.required" => "يرجى ارفاق صورة توضيحية للدورة",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post = Training::whereId($request->hidden_id)->first();
        if ($post) {
            $post->name = $request->name;
            $post->type = $request->type;
            $post->description = $request->description;
            $post->has_certificate = $request->has_certificate;
            $post->learn = $request->learn;
            $post->instructor = $request->instructor;
            $post->category_id = $request->category_id;
            $post->length = $request->length;
            $post->start_at = $request->start_at;
            $post->end_at = $request->end_at;
            $post->thumbnail = $this->Post_update($request, 'image', "IMG-", 'assets/images', $post->thumbnail);
            $departments = Department::find($request->departments);
            $post->departments()->sync($departments);
            $post->update();
            if ($post) {
                return response()->json(['success' => 'تم التعديل بنجاح']);
            } else {
                return response()->json(['success' => 'فشل التعديل']);
            }
        }
    }

    public
    function destroy($id)
    {
        $data = Training::findOrFail($id);
        $data->delete();
    }

################################################################### deleted posts
    public
    function index_trashed()
    {
        if (request()->ajax()) {
            $training = Training::onlyTrashed()->with('subject')->latest()->get();
            return datatables()->of($training)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show_training" id="' . $data->id . '" class="show_training btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit_training" id="' . $data->id . '" class="restore_training btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete_training" id="' . $data->id . '" class="force_delete_training btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })->editColumn('subject', function ($training) {
                    return empty($training->subject) ? 'No producent' : $training->subject->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('admin.training.training.trashed', compact('admin'));
    }

    public
    function show_trashed($id)
    {
        if (request()->ajax()) {
            $data = Training::onlyTrashed()->with('subject')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public
    function restore_post($id)
    {
        if ($id) {
            Training::where('id', $id)->restore();
        }
    }

    public
    function force($id)
    {
        if ($id) {
            Training::where('id', $id)->forceDelete($id);
        }
    }
}
