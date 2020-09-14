<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Category_Training;
use App\Employee;
use App\Department;
use App\Job;
use App\Models\TrainingContents\Training;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeCategory extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
//
        if (request()->ajax()) {
            $post = Department::latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
//                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right">إضافة دورات تدريبية</span></button>';
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('employee.category', compact(['admin']));
    }

    public function store(Request $request)
    {
        $rules = [
            "name" => "required",
        ];
        $messages = [
            "name.required" => "يرجى كتابة اسم القسم",
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new Department();
        $post->name = $request->name;

        $post->save();
        if ($post->save())
            return response()->json(['success' => 'تم إنشاء القسم بنجاح']);
    }

    public function update(Request $request)
    {
        $rules = [
            "name" => "required",
        ];
        $messages = [
            "name.required" => "يرجى كتابة اسم القسم",
        ];

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post = Department::whereId($request->hidden_id)->first();
        if ($post) {
            $post->name = $request->name;
            $post->update();
            if ($post) {
                return response()->json(['success' => 'تم التعديل بنجاح']);
            } else {
                return response()->json(['success' => 'فشل التعديل']);
            }
        }
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = Department::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Department::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function destroy($id)
    {
        $data = Department::with('employees')->findOrFail($id);
        if ($data) {
            $data->employees()->delete();
            $data->delete();
        }
    }

    ############################################### category with trainings
    public function index_edit($id)
    {

        if (request()->ajax()) {
            $post = Category_Training::where('category_id', $id)->orderByDesc('id')->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', function ($data) {
                        $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                        return $button;
                    })
                    ->editColumn('category', function ($post) {
                        return empty($post->emp_categories) ? 'No producent' : $post->emp_categories->name;
                    })
                    ->editColumn('training', function ($post) {
                        return empty($post->trainings) ? 'No producent' : $post->trainings->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        $category = Department::where('id', $id)->first();
        $trainings = Training::all();
        $admin = Admin::where('id', 1)->first();
        return view('employee.categoryShow', compact(['trainings', 'category', 'id', 'admin']));
    }

    public function store_training(Request $request)
    {
        $rules = [
            "category" => "required",
            "training" => "required",
        ];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $tran = implode(",", $request->training);
        $trans = explode(",", $tran);

        for ($i = 0; $i < count($trans); $i++) {
            $post = new Category_Training();
            $post->category_id = $request->category;
            $post->training_id = $trans[$i];
            $post->save();
            $i = $i++;
        }

        if ($post->save())
            return response()->json(['success' => 'تمت الاضافة بنجاح']);
    }

    public function destroy_training($id)
    {
        $data = Category_Training::findOrFail($id);
        if ($data) {
            $data->delete();
        }
    }
}
