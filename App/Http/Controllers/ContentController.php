<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\TitleContent;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index_edit($id)
    {
        if (request()->ajax()) {
            $c = TrainingTitle::where('id', $id)->first();
            $training_id = $c->training_id;
            $post = TitleContent::with('title_C')
                ->whereIn('title_id', function ($query) use ($training_id) {
                    $query->select('id')
                        ->from('training_titles')
                        ->where('training_id', $training_id);
                })
                ->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', 'content.btn.action')
                    ->editColumn('title_C', function ($post) {
                        return empty($post->title_C) ? 'لايوجد عنوان' : $post->title_C->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        $admin = Admin::where('id', 1)->first();
        $c = TrainingTitle::where('id', $id)->first();
        $category = TrainingTitle::all()->where('training_id', $c->training_id);
//return dd($category);
        return view('content.index', compact(['category', 'id', 'admin']));
    }


    public function store(Request $request)
    {
        $rules = [
            "title" => "required",
            "body" => "required",
            "sound" => "nullable|mimetypes:application/octet-stream,audio/mpeg",
            "image" => "nullable|mimes:jpg,png,jpeg,gif,svg",
            "book" => "nullable|mimes:pdf,doc",
        ];
        $messages = [
            "title.required" => "يرجى كتابة عنوان المحتوى",
            "body.required" => "يرجى كتابة نص المحتوى",
            "sound.mimetypes" => "يرجى اختيار ملف صوتي",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",
            "book.mimes" => "يرجى اختيار ملف من نوع: pdf,doc",
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new TitleContent();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->title_id = $request->title_id;
        $post->image = $this->Post_Save($request, 'image', "IMG-", 'assets/images');
        $post->sound = $this->Post_Save($request, 'sound', "AUD-", 'assets/sounds');
        $post->book = $this->Post_Save($request, 'book', "BOK-", 'assets/books');
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
            $data = TitleContent::with(['title_C'])->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = TitleContent::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = [
            "title" => "required",
            "body" => "required",
            "sound" => "nullable|mimetypes:application/octet-stream,audio/mpeg",
            "image" => "nullable|mimes:jpg,png,jpeg,gif,svg",
            "book" => "nullable|mimes:pdf,doc",
        ];
        $messages = [
            "title.required" => "يرجى كتابة عنوان المحتوى",
            "body.required" => "يرجى كتابة نص المحتوى",
            "sound.mimetypes" => "يرجى اختيار ملف صوتي",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",
            "book.mimes" => "يرجى اختيار ملف من نوع: pdf,doc",
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post = TitleContent::whereId($request->hidden_id)->first();
        if ($post) {
            $post->title = $request->title;
            $post->body = $request->body;
            $post->title_id = $request->title_id;
            $post->image = $this->Post_update($request, 'image', "IMG-", 'assets/images', $post->image);
            $post->sound = $this->Post_update($request, 'sound', "AUD-", 'assets/sounds', $post->sound);
            $post->book = $this->Post_update($request, 'book', "BOK-", 'assets/books', $post->book);
            if ($request->video == null)
                $post->video_url = null;
            $post->video_url = $request->video;
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
        $data = TitleContent::findOrFail($id);
        $data->delete();
    }

################################################################### deleted posts
    public function index_trashed()
    {
        if (request()->ajax()) {
            $training = TitleContent::onlyTrashed()->with('title_C')->latest()->get();
            return datatables()->of($training)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit_training" id="' . $data->id . '" class="restore_training btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete_training" id="' . $data->id . '" class="force_delete_training btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })->editColumn('title_C', function ($training) {
                    return empty($training->title_C) ? 'No producent' : $training->title_C->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('content.trashed', compact('admin'));
    }

    public function show_trashed($id)
    {
        if (request()->ajax()) {
            $data = TitleContent::onlyTrashed()->with('title_C')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function restore_post($id)
    {
        if ($id) {
            TitleContent::where('id', $id)->restore();
        }
    }

    public function force($id)
    {
        if ($id) {
            TitleContent::where('id', $id)->forceDelete($id);
        }
    }
}
