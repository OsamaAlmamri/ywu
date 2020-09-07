<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\WomenContents\WomenCategory;
use App\Models\WomenContents\WomenPosts;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WomenController extends Controller
{
    use JsonTrait;
    use PostTrait;
    public function index()
    {
        if (request()->ajax()) {
            $post=WomenPosts::latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show_post" id="' . $data->id . '" class="show_post btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit_post" id="' . $data->id . '" class="edit_post btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete_post" id="' . $data->id . '" class="delete_post btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin=Admin::where('id',1)->first();
        return view('women.index',compact(['admin']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
            $rules=$this->Post_Rules();
            $messages=$this->Post_Messages();
            $error = Validator::make($request->all(), $rules,$messages);

            if ($error->fails()) {
                return response()->json(['errors' => $error->errors()->all()]);
            }
            $post = new WomenPosts();
            $post->title=$request->title;
            $post->body=$request->body;
            $post->image= $this->Post_Save($request,'image',"IMG-",'assets/images');
            $post->book=$this->Post_Save($request,'book',"BOK-",'assets/books');
            if($request->video==null)
                $post->video_url = null;
            $post->video_url =$request->video;
            $post->save();
            if ($post->save())
                return response()->json(['success' => 'تم النشر بنجاح']);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = WomenPosts::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {       if (request()->ajax()) {
                $data = WomenPosts::whereId($id)->first();
                return response()->json(['data' => $data]);
    }
    }

    public function update(Request $request)
    {
        $rules=$this->Post_Rules();
        $messages=$this->Post_Messages();
        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post=WomenPosts::whereId($request->hidden_id)->first();
        if($post){
            $post->title=$request->title;
            $post->body=$request->body;
            $post->image = $this->Post_update($request,'image',"IMG-",'assets/images',$post->image);
            $post->book=$this->Post_update($request,'book',"BOK-",'assets/books',$post->book);
            if($post->video_url!=null || $post->video_url==null && $request->video!=null){
                $post->video_url=$request->video;
            }
            else{$post->video_url=null;}
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
        $data = WomenPosts::findOrFail($id);
        $data->delete();
    }
################################################################### deleted posts
    public function index_trashed()
    {
        if (request()->ajax()) {
            $post=WomenPosts::onlyTrashed()->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin=Admin::where('id',1)->first();
        return view('women.trashed',compact('admin'));
    }
    public function edit_trashed($id)
    {       if (request()->ajax()) {
        $data = WomenPosts::onlyTrashed()->whereId($id)->first();
        return response()->json(['data' => $data]);
    }
    }

    public function restore_post($id){
        if ($id) {
            WomenPosts::where('id',$id)->restore();
        }
    }
    public function force($id){
        if ($id) {
            WomenPosts::where('id',$id)->forceDelete($id);
        }
    }
}
