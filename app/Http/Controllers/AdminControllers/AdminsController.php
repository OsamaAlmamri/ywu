<?php

namespace App\Http\Controllers\AdminControllers;

use App\Admin;
use App\Branch;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Job;
use App\Models\Shop\ShopCategory;
use App\Traits\PostTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminsController extends Controller
{
    use PostTrait;

    public function Admin()
    {
        return redirect()->route('home');
    }

    public function __construct()
    {
        $this->middleware('permission:show admins', ['only' => ['index', 'show', 'Update_Admin_Details', 'Admin_update']]);
        $this->middleware('permission:manage admins', ['only' => ['Update_Admin_Details', 'Admin_update', 'restore_post', 'force', 'changeOrder', 'destroy', 'edit', 'store', 'update', 'active']]);
        $this->middleware('permission:active admins', ['only' => ['active']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $post = Admin::withTrashed()->where('type', 'admin')->get();
            $data = DB::table('admins')
                ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'admins.id')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('admins.*',
                    'roles.name as role_name')->where('type', 'admin');
            if (auth()->user()->getRoleNames()->first() !== 'Developer')
                $data = $data->where('roles.name', '<>', 'Developer');
            $data = $data->orderByDesc('id')->get();

            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.dashboard.admins.btn.action')
                    ->addColumn('btn_status', 'admin.dashboard.admins.btn.status')
                    ->rawColumns(['action', 'btn_status'])
                    ->make(true);
            }
        }
        return view('admin.dashboard.admins.index');
    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Admin::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }

    private function checkInputes($request, $type = 'create')
    {
        $rules = [
            "name" => "required",
            'email' => ['required', 'string', 'email', ($type == 'create') ? Rule::unique('admins', 'email') : Rule::unique('admins', 'email')->ignore($request->hidden_id)],
            'phone' => ['required', 'numeric', 'digits:9', 'starts_with:77,73,74,70,71', ($type == 'create') ? Rule::unique('admins', 'phone') : Rule::unique('admins', 'phone')->ignore($request->hidden_id)],
            'password' => [($type == 'create') ? 'required' : 'nullable'],

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
        $user = Admin::create(array_merge($request->all(), [
            'type' => 'admin',
            'status' => 1,
        ]));
        $user->syncRoles([$request->role]);

        return response()->json(['success' => 'تم إنشاء الحساب بنجاح']);
    }

    public function update(Request $request)
    {
        $error = $this->checkInputes($request, 'update');
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $user = Admin::find($request->hidden_id);

        if ($request->password == '') {
            $user->update(array_merge($request->except('password')));
        } else {
            $request['password'] = Hash::make($request->password);
            $user->update($request->all());

        }
        if ($user) {
            $user->syncRoles([$request->role]);
            return response()->json(['success' => 'تم التعديل بنجاح']);
        } else {
            return response()->json(['success' => 'فشل التعديل']);
        }

    }

    public
    function show($id)
    {
        if (request()->ajax()) {
            $data = Admin::find($id);
            return response()->json(['data' => $data]);
        }
    }

    public
    function edit($id)
    {
        if (request()->ajax()) {
            $data = Admin::find($id);
            return response()->json(['role' => getFirstRole($id), 'data' => $data]);
        }
    }

    public
    function destroy($id)
    {
        $data = Admin::findOrFail($id);
        $data->status = 1;
        $data->update();
        if ($data) {
            $data->forceDelete();
        }
    }


}
