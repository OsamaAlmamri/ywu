<?php

namespace App\Http\Controllers\AdminControllers;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionsController extends Controller
{
    //

    public function __construct()
    {

//        $this->middleware('auth');
        $this->middleware('permission:show permissions', ['only' => ['index']]);
        $this->middleware('permission:manage permissions', ['only' => ['create', 'edit', 'update', 'delete', 'deleteMulti']]);
        $this->middleware('permission:manage deleted permissions', ['only' => ['deleted', 'forceDelete', 'restore', 'delete']]);

    }

    private function addRoles()
    {
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Developer']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Seller']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'SuperAdmin']);
        $role = Role::create(['guard_name' => 'admin', 'name' => 'Admin']);

    }

    private function addPermissions()
    {
        ///////////////////////
        //php artisan cache:forget spatie.permission.cache
        //php artisan cache:clear
        /////////////////////////////
        /********************* Permissions  *********************/
        $permission = Permission::create(['name' => 'show permissions']);
        $permission = Permission::create(['name' => 'manage permissions']);//add ,update , delete
        $permission = Permission::create(['name' => 'setup permissions']);//restore forceDelete


        /********************* Admins  *********************/
        $permission = Permission::create(['name' => 'show admins']);
        $permission = Permission::create(['name' => 'active admins']);
        $permission = Permission::create(['name' => 'manage admins']);//add ,update , delete

        /********************* Users  *********************/
        $permission = Permission::create(['name' => 'show sellers']);
        $permission = Permission::create(['name' => 'active sellers']);
        $permission = Permission::create(['name' => 'manage sellers']);//add ,update , delete

        /********************* Users  *********************/
        $permission = Permission::create(['name' => 'show users']);
        $permission = Permission::create(['name' => 'active users']);
        $permission = Permission::create(['name' => 'manage users']);//add ,update , delete

        /********************* employees  *********************/
        $permission = Permission::create(['name' => 'show employees']);
        $permission = Permission::create(['name' => 'active employees']);
        $permission = Permission::create(['name' => 'manage employees']);//add ,update , delete

        /********************* employees_settings  *********************/
        $permission = Permission::create(['name' => 'show employees_sections']);
        $permission = Permission::create(['name' => 'manage employees_sections']);//add ,update , delete

        $permission = Permission::create(['name' => 'show employees_jobs']);
        $permission = Permission::create(['name' => 'manage employees_jobs']);//add ,update , delete

        /********************* employees  *********************/
        $permission = Permission::create(['name' => 'show share_users']);
        $permission = Permission::create(['name' => 'active share_users']);
        $permission = Permission::create(['name' => 'manage share_users']);//add ,update , delete

        /********************* Users  *********************/
        $permission = Permission::create(['name' => 'show customers']);
        $permission = Permission::create(['name' => 'active customers']);
        $permission = Permission::create(['name' => 'manage customers']);//add ,update , delete

        /********************* training  *********************/
        $permission = Permission::create(['name' => 'show training']);
        $permission = Permission::create(['name' => 'manage training']);//add ,update , delete

        /********************* women postes  *********************/
        $permission = Permission::create(['name' => 'show women']);
        $permission = Permission::create(['name' => 'manage women']);//add ,update , delete

        /********************* women postes  *********************/
        $permission = Permission::create(['name' => 'show consultant']);
        $permission = Permission::create(['name' => 'active consultant']);
        $permission = Permission::create(['name' => 'manage consultant']);//add ,update , delete

        /********************* products  *********************/
        $permission = Permission::create(['name' => 'show categories']);
        $permission = Permission::create(['name' => 'manage categories']);//add ,update , delete

        /********************* orders  *********************/
        $permission = Permission::create(['name' => 'show products_attributes']);
        $permission = Permission::create(['name' => 'manage products_attributes']);//add ,update , delete

        /********************* slides  *********************/
        $permission = Permission::create(['name' => 'show slides']);
        $permission = Permission::create(['name' => 'manage slides']);//add ,update , delete

        /********************* slides  *********************/
        $permission = Permission::create(['name' => 'show activates']);
        $permission = Permission::create(['name' => 'manage activates']);//add ,update , delete

        /********************* setting  *********************/
        $permission = Permission::create(['name' => 'show setting']);
        $permission = Permission::create(['name' => 'manage setting']);//add ,update , delete

        /********************* order_statuses  *********************/
        $permission = Permission::create(['name' => 'show orders']);
        $permission = Permission::create(['name' => 'manage orders']);//add ,update , delete

        /********************* order_statuses  *********************/
        $permission = Permission::create(['name' => 'show payment']);
        $permission = Permission::create(['name' => 'manage payment']);//add ,update , delete

        /********************* reports  *********************/
        $permission = Permission::create(['name' => 'show orders_report']);
        $permission = Permission::create(['name' => 'show products_report']);


        /********************* reports  *********************/
        $permission = Permission::create(['name' => 'show products']);
        $permission = Permission::create(['name' => 'manage products']);
        $permission = Permission::create(['name' => 'manage products_questions']);
        $permission = Permission::create(['name' => 'manage products_questions_replies']);


    }


    public function index()
    {
//        /********************* order_statuses  *********************/
//        $permission = Permission::create(['name' => 'show payment']);
//        $permission = Permission::create(['name' => 'manage payment']);//add ,update , delete


//        \auth()->user()->syncRoles(['Developer']);
//        $this->addRoles();
//        if (Auth::user()->can('show permissions') == false)
//            return redirect()->route('home')->with('error', 'ليس لديك صلاحية الوصول');
        if (auth()->user()->getRoleNames()->first() === 'Developer')
            $roles = Role::all();
        else
            $roles = Role::all()->where('name', '<>', 'Developer');

        return view('admin.dashboard.permissions.index')
            ->with('roles', $roles);
    }

    public function edit($id)
    {
//        if (Auth::user()->can('manage permissions') == false)
//            return redirect()->route('home')->with('error', 'ليس لديك صلاحية الوصول');
//$this->addPermissions();

        $role = Role::find($id);
        $RolePermission = $role->getAllPermissions();
        $oldRolePermission = [];
        foreach ($RolePermission as $old) {
            $oldRolePermission[] = $old->id;
        }
        $permissions = Permission::all();
        $subPermissins = [];
        foreach ($permissions as $permission) {
            $t = explode(' ', $permission->name);
            $t = $t[count($t) - 1];
            $subPermissins[$t][] = $permission;
        }
        return view('admin.dashboard.permissions.create')
            ->with('role', $role)
            ->with('oldRolePermission', $oldRolePermission)
            ->with('permissions', $subPermissins);


    }

    public function updateUserRole($user_id, $role)
    {
        $user = User::find($user_id);
        $user->syncRoles([$role]);

//        $user->assignRole($role);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save;
        $permissions = isset($request->permissions) ? $request->permissions : [];
        $allPermissions = Permission::all()->whereIn('id', $permissions);
        $role->syncPermissions($allPermissions);
        return redirect()->route('admin.permissions.index')->with('success', '  permissions updated successfully');
    }


    public function addNewRole(Request $request)
    {
//        $exitCode = Artisan::call('cache:forget spatie.permission.cache');
//        $exitCode = Artisan::call('cache:clear');
        $validator = Validator::make($request->all(), [
            'name' => [
                'required', 'string', (isset($request->role_id) and $request->role->id > 0) ? Rule::unique('roles', 'name')->ignore($request->id) : Rule::unique('roles', 'name')],
        ], [
            'name.required' => 'إسم الصلاحية مطلوب',
            'name.unique' => '   هذا الاسم مستخدم  من قبل',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);

        }
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->name]);
        return response()->json(['success' => '1'], 200);
    }


    public function delete($id)
    {
        $role = Role::find(decrypt($id));
//        $users = User::role($role->name)->get();
        if ($role->users()->count() > 0)
            return redirect()->back()->with('warning', 'لايمكن حذف هذا role لان هناك مستخدمين  مرتبطين بهذا النوع');
        $role->syncPermissions([]);
        $exitCode = Artisan::call('cache:forget spatie.permission.cache');
        $exitCode = Artisan::call('cache:clear');
        $role->delete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح');


    }


}



