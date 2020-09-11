<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Question;
use App\Result;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index($id)
    {
        if (request()->ajax()) {
            $post = Question::with('training')->where('training_id', $id)->orderByDesc('id')->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', 'questions.btn.action')
                    ->addColumn('btn_image', 'questions.btn.image')
                    ->editColumn('training', function ($post) {
                        return $post->training->name;
                    })
                    ->rawColumns(['action', 'btn_image'])
                    ->make(true);
            }
        }

        $category = Training::where('id', $id)->first();
        $admin = Admin::where('id', 1)->first();
        return view('questions.show', compact(['category', 'id', 'admin']));
    }


    public function results($id)
    {
        if (request()->ajax()) {
            $post = Result::with(['training','user'])->where('training_id', $id)->orderByDesc('id')->get();
            if ($post) {
                return datatables()->of($post)
                    ->editColumn('training', function ($post) {
                        return $post->training->name;
                    })
                    ->editColumn('user_type', function ($post) {
                        $type2=   ($post->user->type=='share_users')? "  ". trans("dataTable.share_userType.".$post->user->share_user->type) :' ' ;
                        return trans("dataTable.userType.".$post->user->type) . $type2;

                    })
                    ->make(true);
            }
        }$admin = Admin::where('id', 1)->first();
        return view('questions.results', compact([ 'id', 'admin']));
    }

    private function check_inputes($request)
    {
        $rules = [
            "text" => "required",
            "option1" => "required",
            "option2" => "required",
            "option3" => "required",
            "option4" => "required",
            "answer" => "required",
            "image" => "nullable|mimes:jpg,png,jpeg,gif,svg",
        ];
        $messages = [
            "text.required" => "يرجى كتابة السؤال",
            "answer.required" => "يرجى تحدبد الاجابة الصحيحة",
            "option1.required" => "يرجى كتابة الخيار  الاول ",
            "option2.required" => "يرجى كتابة الخيار  الثاني ",
            "option3.required" => "يرجى كتابة الخيار  الثالث ",
            "option4.required" => "يرجى كتابة الخيار  الرابع ",
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
        $question = Question::create(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم الاضافة  بنجاح']);
    }


    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Question::whereId($id)->first();
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
        $question = Question::whereId($request->hidden_id)->first();
        $image = $this->Post_update($request, 'image', "IMG-", 'assets/images', $question->image);
        $question = $question->update(array_merge($request->except('image'),
            [
                'image' => $image,
            ]));
        return response()->json(['success' => 'تم التعديل  بنجاح']);


    }

    public function destroy($id)
    {
        $data = Question::findOrFail($id);
        $data->delete();
    }
}
