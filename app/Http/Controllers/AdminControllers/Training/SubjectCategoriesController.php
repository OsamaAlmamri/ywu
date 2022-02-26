<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Admin;
use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\SubjectCategory;

use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SubjectCategoriesController extends Controller
{
    use JsonTrait;
    use PostTrait;
    public function index()
    {
        if (request()->ajax()) {
            $post=SubjectCategory::latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin=User::where('id',1)->first();
        return view('admin.training.subject_categories.index',compact(['admin']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
//        $rules=$this->Post_Rules();
//        $messages=$this->Post_Messages();
        $rules=["name"=> "required","name_en"=> "required",];
        $messages=[ "name.required"=> "يرجى كتابة اسم المادة",];
        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new SubjectCategory();
        $post->name=$request->name;
        $post->name_en=$request->name_en;
        $post->save();
        if ($post->save())
            return response()->json(['success' => 'تم النشر بنجاح']);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = SubjectCategory::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {       if (request()->ajax()) {
        $data = SubjectCategory::whereId($id)->first();
        return response()->json(['data' => $data]);
    }
    }

    public function update(Request $request)
    {
        $rules=["name"=> "required","name_en"=> "required",];
        $messages=[ "name.required"=> "يرجى كتابة اسم المادة",];
        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post=SubjectCategory::whereId($request->hidden_id)->first();
        if($post){
            $post->name=$request->name;
            $post->name_en=$request->name_en;

            $post->update();
            if ($post) {
                return response()->json(['success' => 'تم التعديل بنجاح']);
            } else {
                return response()->json(['success' => 'فشل التعديل']);
            }
        }
    }

    public function destroy($id)
    {
        $data = SubjectCategory::findOrFail($id);
        $data->delete();
    }
################################################################### deleted posts
    public function index_trashed()
    {
        if (request()->ajax()) {
            $post=SubjectCategory::onlyTrashed()->with('category')->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin=User::where('id',1)->first();
        return view('admin.training.subject_categories.trashed',compact('admin'));
    }
    public function edit_trashed($id)
    {       if (request()->ajax()) {
        $data = SubjectCategory::onlyTrashed()->whereId($id)->first();
        return response()->json(['data' => $data]);
    }
    }

    public function restore_post($id){
        if ($id) {
            SubjectCategory::where('id',$id)->restore();
        }
    }
    public function force($id){
        if ($id) {
            SubjectCategory::where('id',$id)->forceDelete($id);
        }
    }
}
