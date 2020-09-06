<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Branch;
use App\Department;
use App\EmployeeCategory;
use App\Job;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FrontEmployeeController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
        if (request()->ajax()) {
            $post = User::with('employee')->where('type', 'employees')->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm" style="float: right"><span class=\'glyphicon glyphicon-pencil\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">توقيف الحساب</button>';
                    return $button;
                })
                ->editColumn('department', function ($post) {
                    return empty($post->employee->department) ? 'تم حذف القسم' : $post->employee->department->name;
                })
                ->editColumn('job', function ($post) {
                    return empty($post->employee->job) ? 'تم حذف الوظيفة' : $post->employee->job->name;
                })
                ->editColumn('branch', function ($post) {
                    return empty($post->employee->branch) ? 'تم حذف الفرع' : $post->employee->branch->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        $departments = Department::all();
        $jobs = Job::all();
        $branchs = Branch::all();
        return view('employee.index', compact(['admin', 'branchs', 'departments', 'jobs']));
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

    private function checkInputes($request, $type = 'create')
    {
        $rules = [
            "name" => "required",
            'email' => ['required', 'string', 'email', ($type == 'create') ? Rule::unique('users', 'email') : Rule::unique('users', 'email')->ignore($request->hidden_id)],
            'phone' => ['required', 'numeric', 'digits:9', 'starts_with:77,73,74,70,71', ($type == 'create') ? Rule::unique('users', 'phone') : Rule::unique('users', 'phone')->ignore($request->hidden_id)],
            'password' => [($type == 'create') ? 'required' : 'nullable'],
            "department_id" => "required",
            "job_id" => "required",
            "branch_id" => "required",
        ];
        $messages = [
            "name.required" => "يرجى كتابة اسم الموظف",
            "phone.required" => "يرجى كتابة رقم الهاتف",
            "phone.numeric" => "رقم الهاتف يجب ان يكون ارقام فقط ",
            "phone.digits" => "يجب ان يكون رقم الهاتف 9 ارقام",
            "phone.starts_with" => "قم بكتابة رقم هاتفك الشخصي",
            "phone.unique" => "يوجد  مستخدم مسجل بهذا الرقم ",
            "email.required" => "يرجى كتابة الايميل",
            "email.email" => "يرجى كتابة الايميل بشكل صحيح",
            "email.unique" => "هذا الايميل مسجل باسم مستخدم مسبقا يرجى اختيار ايميل اخر",
            "password.required" => "يرجى كتابة كلمة المرور",
            "department_id.required" => "يرجى تحديد القسم",
            "branch_id.required" => "يرجى تحديد الفرع",
            "job_id.required" => "يرجى تحديد الوظيفة",
        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    public function store(Request $request)
    {
        $error = $this->checkInputes($request);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $request['password'] = bcrypt($request->password);
        $request['type'] = 'employees';
        $user = User::create($request->all());
        $emp = Employee::create(array_merge($request->all(), ['user_id' => $user->id]));
        return response()->json(['success' => 'تم إنشاء الحساب بنجاح']);
    }

    public function update(Request $request)
    {
        $error = $this->checkInputes($request, 'update');
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $user = User::find($request->hidden_id);

        if ($request->password == '') {
            $user->update(array_merge($request->except('password')));
        } else {
            $request['password'] = Hash::make($request->password);
            $user->update($request->all());
        }
        $user->employee->update($request->all());
        if ($user) {
            return response()->json(['success' => 'تم التعديل بنجاح']);
        } else {
            return response()->json(['success' => 'فشل التعديل']);
        }

    }

    public
    function show($id)
    {
        if (request()->ajax()) {
            $data = User::with('employee')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public
    function edit($id)
    {
        if (request()->ajax()) {
            $data = User::with('employee')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public
    function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->status = 1;
        $data->update();
        if ($data) {
            $data->delete();
        }
    }

################################################################### deleted posts
    public
    function index_trashed()
    {
        if (request()->ajax()) {
//            $post = Employee::onlyTrashed()->with('category')->latest()->get();
            $post = User::onlyTrashed()->with('employee')->where('type', 'employees')->get();

            return datatables()->of($post)
                ->addColumn('action', function ($data) {
//                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right"><span class=\'fa fa-eye\'></span></button>';
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->editColumn('department', function ($post) {
                    return empty($post->employee->department) ? 'تم حذف القسم' : $post->employee->department->name;
                })
                ->editColumn('job', function ($post) {
                    return empty($post->employee->job) ? 'تم حذف الوظيفة' : $post->employee->job->name;
                })
                ->editColumn('branch', function ($post) {
                    return empty($post->employee->branch) ? 'تم حذف الفرع' : $post->employee->branch->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('employee.trashed', compact('admin'));
    }

    public
    function index_trashed_id($id)
    {
        if (request()->ajax()) {
            $post = User::onlyTrashed()->where('id', $id)->get();
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

    public
    function edit_trashed($id)
    {
        if (request()->ajax()) {
            $data = User::onlyTrashed()->with('employee')->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public
    function restore_post($id)
    {
        $data = User::onlyTrashed()->findOrFail($id);
        $data->status = 1;
        $data->update();
        if ($data) {
            $data->restore();
        }
    }

    public
    function force($id)
    {
        if ($id) {
            Employee::where('user_id', $id)->forceDelete($id);
            User::where('id', $id)->forceDelete($id);
        }
    }
}
