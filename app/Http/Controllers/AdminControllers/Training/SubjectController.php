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

class SubjectController extends Controller
{
    use JsonTrait;
    use PostTrait;
    public function index()
    {
        if (request()->ajax()) {
            $post=Subject::with('category')->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })->editColumn('category',function ($post){
                    return $post->category->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin=User::where('id',1)->first();
        $categories=SubjectCategory::all();
        return view('admin.training.subject.index',compact(['categories','admin']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
//        $rules=$this->Post_Rules();
//        $messages=$this->Post_Messages();
        $rules=["name"=> "required",];
        $messages=[ "name.required"=> "يرجى كتابة اسم المادة",];
        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new Subject();
        $post->name=$request->name;
        $post->category_id = $request->category;
        $post->save();
        if ($post->save())
            return response()->json(['success' => 'تم النشر بنجاح']);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = Subject::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {       if (request()->ajax()) {
        $data = Subject::whereId($id)->first();
        return response()->json(['data' => $data]);
    }
    }

    public function update(Request $request)
    {
        $rules=["name"=> "required",];
        $messages=[ "name.required"=> "يرجى كتابة اسم المادة",];
        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post=Subject::whereId($request->hidden_id)->first();
        if($post){
            $post->name=$request->name;
            $post->category_id = $request->category;
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
        $data = Subject::findOrFail($id);
        $data->delete();
    }
################################################################### deleted posts
    public function index_trashed()
    {
        if (request()->ajax()) {
            $post=Subject::onlyTrashed()->with('category')->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })->editColumn('category',function ($post){
                    return $post->category->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin=User::where('id',1)->first();
        return view('admin.training.subject.trashed',compact('admin'));
    }
    public function edit_trashed($id)
    {       if (request()->ajax()) {
        $data = Subject::onlyTrashed()->whereId($id)->first();
        return response()->json(['data' => $data]);
    }
    }

    public function restore_post($id){
        if ($id) {
            Subject::where('id',$id)->restore();
        }
    }
    public function force($id){
        if ($id) {
            Subject::where('id',$id)->forceDelete($id);
        }
    }
}
