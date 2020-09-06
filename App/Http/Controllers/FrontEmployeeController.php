<?php

namespace App\Http\Controllers;

use App\Admin;
use App\EmployeeCategory;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontEmployeeController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
        if (request()->ajax()) {
            $post = Employee::with('category')->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">توقيف الحساب</button>';
                    return $button;
                })->editColumn('category', function ($post) {
                    return empty($post->category) ? 'تم حذف القسم' : $post->category->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        $category = EmployeeCategory::all();
        return view('employee.index', compact(['admin', 'category']));
    }

    public function index_id($id)
    {
        if (request()->ajax()) {
            $post = Employee::where('id', $id)->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">توقيف الحساب</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('employee.index_id', compact(['id', 'admin']));
    }

    public function store(Request $request)
    {
        $rules = [
            "name" => "required",
            "email" => "required|email|unique:employees,email",
            "password" => "required",
            "category" => "required",
        ];
        $messages = [
            "name.required" => "يرجى كتابة اسم الموظف",
            "email.required" => "يرجى كتابة الايميل",
            "email.email" => "يرجى كتابة الايميل بشكل صحيح",
            "email.unique" => "هذا الايميل مسجل باسم مستخدم مسبقا يرجى اختيار ايميل اخر",
            "password.required" => "يرجى كتابة كلمة المرور",
            "category.required" => "يرجى تحديد الوظيفة",
        ];
        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $post = new Employee();
        $post->name = $request->name;
        $post->email = $request->email;
        $post->password = bcrypt($request->password);
        $post->category_id = $request->category;

        $post->save();
        if ($post->save())
            return response()->json(['success' => 'تم إنشاء الحساب بنجاح']);
    }

    public function update(Request $request)
    {
        $rules = [
            "name" => "required",
            "email" => "required|email",
            "category" => "required",
        ];
        $messages = [
            "name.required" => "يرجى كتابة اسم الموظف",
            "email.required" => "يرجى كتابة الايميل",
            "email.email" => "يرجى كتابة الايميل بشكل صحيح",
            "password.required" => "يرجى كتابة كلمة المرور",
            "category.required" => "يرجى تحديد الوظيفة",
        ];

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $post = Employee::whereId($request->hidden_id)->first();
        if ($post) {
            $post->name = $request->name;
            $post->email = $request->email;
            $post->category_id = $request->category;
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
            $data = Employee::with('category')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Employee::with('category')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function destroy($id)
    {
        $data = Employee::findOrFail($id);
        $data->status = "غير مفعل";
        $data->update();
        if ($data) {
            $data->delete();
        }
    }

################################################################### deleted posts
    public function index_trashed()
    {
        if (request()->ajax()) {
            $post = Employee::onlyTrashed()->with('category')->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button .= '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })->editColumn('category', function ($post) {
                    return empty($post->category) ? 'تم حذف القسم' : $post->category->name;
//                    return $post->category->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('employee.trashed', compact('admin'));
    }

    public function index_trashed_id($id)
    {
        if (request()->ajax()) {
            $post = Employee::onlyTrashed()->where('id', $id)->get();
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
        $admin = Admin::where('id', 1)->first();
        return view('employee.trashed_id', compact(['id', 'admin']));
    }

    public function edit_trashed($id)
    {
        if (request()->ajax()) {
            $data = Employee::onlyTrashed()->with('category')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function restore_post($id)
    {
        $data = Employee::onlyTrashed()->findOrFail($id);
        $data->status = " مفعل";
        $data->update();
        if ($data) {
            $data->restore();
        }
    }

    public function force($id)
    {
        if ($id) {
            Employee::where('id', $id)->forceDelete($id);
        }
    }
}
