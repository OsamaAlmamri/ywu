<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Admin;
use App\Models\WomenContents\WomenPosts;
use App\Traits\PostTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class WomenController extends Controller
{
    use PostTrait;

    public function __construct()
    {
        $this->middleware('permission:show women', ['only' => ['index', 'show', 'index_trashed']]);
        $this->middleware('permission:manage activates', ['only' => ['index_trashed', 'edit_trashed', 'restore_post', 'force', 'changeOrder', 'destroy', 'edit', 'store', 'update', 'active']]);
        $this->middleware('permission:active activates', ['only' => ['active']]);
    }

    public function index()
    {
//
//        $p = WomenPosts::all();
//
//        foreach ($p as $post) {
//            $post->title = (['ar' => $post->title, 'en' => $post->title]);
//            $post->body = (['ar' => $post->body, 'en' => $post->body]);
//            $post->save();
//
//        }


        if (request()->ajax()) {
            $post = WomenPosts::latest()->get();
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
        $admin = User::where('id', 1)->first();
        return view('admin.training.women.index', compact(['admin']));
    }

    public function create()
    {
        //
    }

    private function checkInputes($request, $type = 'create')
    {
        $rules = [
            "title" => "required_if:lang_type,both|required_if:lang_type,ar",
            "title_en" => "required_if:lang_type,both|required_if:lang_type,en",
            "body" => "required_if:lang_type,both|required_if:lang_type,ar",
            "body_en" => "required_if:lang_type,both|required_if:lang_type,en",

//            "category_id" => "required|integer",
            //"sound"=>"mimetypes:application/octet-stream,audio/mpeg",
            'image' => [($type == 'create') ? 'required' : 'nullable', 'image'],
//            "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg",
            "book_external_link" => "required_if:book_type,book_external",
            "book" => [($type == 'create') ? 'required_if:book_type,book_internal' : 'file', ($type != 'created' and $request->hidden_book == null) ? 'required_if:book_type,book_internal' : 'file', 'mimes:pdf,doc'],

        ];
        $messages = [
            "title.required" => "يرجى كتابة عنوان المنشور",
            "body.required" => "يرجى كتابة نص المحتوى",
            //"category_id.required" => "يرجى اختيار احد الاقسام للنشر فيه",
            "image.required" => "يرجى اختيار صورة للرفع",
            "image.image" => "يرجى اختيار صورة للرفع",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",
            //"image.max"=>"لايمكن رفع صورة حجمها اكبر من 2 ميغا بايت",
            "book.mimes" => "يرجى اختيار ملف من نوع: pdf,doc",
            "book_external_link.required_if" => "يرجى وضع رابط الكتاب  ",
            "book.required_if" => "يرجى اختيار كتاب ",
        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    public function store(Request $request)
    {
        $rules = $this->Post_Rules();
        $messages = $this->Post_Messages();
        $error = $this->checkInputes($request, 'create');
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new WomenPosts();
        $post->lang_type =  $request->lang_type;
        $post->title = isset($request->title) ? $request->title : "";
        $post->title_en = isset($request->title_en) ? $request->title_en : "";
        $post->body = isset($request->body) ? $request->body : "";
        $post->body_en = isset($request->body_en) ? $request->body_en : "";

        $post->image = $this->Post_Save($request, 'image', "IMG-", 'assets/images');
        if ($request->book_type == 'book_internal')
            $post->book = $this->Post_Save($request, 'book', "BOK-", 'assets/books');

        if ($request->book_type == 'book_external')
            $post->book_external_link = $request->book_external_link;

        if ($request->video == null)
            $post->video_url = null;
        $post->video_url = $request->video;

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
    {
        if (request()->ajax()) {
            $data = WomenPosts::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {

        $error = $this->checkInputes($request, 'update');
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = WomenPosts::whereId($request->hidden_id)->first();
        if ($post) {
            $post->title = isset($request->title) ? $request->title : "";
            $post->title_en = isset($request->title_en) ? $request->title_en : "";
            $post->body = isset($request->body) ? $request->body : "";
            $post->body_en = isset($request->body_en) ? $request->body_en : "";
            $post->lang_type =  $request->lang_type;

            $post->image = $this->Post_update($request, 'image', "IMG-", 'assets/images', $post->image);
            $post->book = $this->Post_update($request, 'book', "BOK-", 'assets/books', $post->book);
            if ($post->video_url != null || $post->video_url == null && $request->video != null) {
                $post->video_url = $request->video;
            } else {
                $post->video_url = null;
            }
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
            $post = WomenPosts::onlyTrashed()->latest()->get();
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
        $admin = User::where('id', 1)->first();
        return view('admin.training.women.trashed', compact('admin'));
    }

    public function edit_trashed($id)
    {
        if (request()->ajax()) {
            $data = WomenPosts::onlyTrashed()->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function restore_post($id)
    {
        if ($id) {
            WomenPosts::where('id', $id)->restore();
        }
    }

    public function force($id)
    {
        if ($id) {
            WomenPosts::where('id', $id)->forceDelete($id);
        }
    }
}
