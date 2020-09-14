<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TitleController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index($id)
    {
        if (request()->ajax()) {
            $post = TrainingTitle::with('training')->where('training_id', $id)->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', 'title.btn.action')
                    ->editColumn('training', function ($post) {
                        return $post->training->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        $category = Training::where('id', $id)->first();
        $admin = Admin::where('id', 1)->first();
        return view('title.show', compact(['category', 'id', 'admin']));
    }

    public function store(Request $request)
    {
        $rules = [
            "name" => "required"
        ];
        $messages = [
            "name.required" => "يرجى كتابة العنوان"
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new TrainingTitle();
        $post->name = $request->name;
        $post->training_id = $request->training;
        $post->save();
        if ($post->save())
            return response()->json(['success' => 'تم النشر بنجاح']);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = TrainingTitle::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = TrainingTitle::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = [
            "name" => "required"
        ];
        $messages = [
            "name.required" => "يرجى كتابة العنوان"
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post = TrainingTitle::whereId($request->hidden_id)->first();
        if ($post) {
            $post->name = $request->name;
            $post->training_id = $request->training;
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
        $data = TrainingTitle::findOrFail($id);
        $data->delete();
    }
}
