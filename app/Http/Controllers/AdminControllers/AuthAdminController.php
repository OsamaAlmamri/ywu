<?php

namespace App\Http\Controllers\AdminControllers;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AuthAdminController extends Controller
{
    use PostTrait;

    public function Admin_login()
    {
        return view('auth.login_1');
    }

    public function adminLoginCheck(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|exists:users',
        ];
        $messages = [
            'email.exists' => 'قم بادخال الايميل بشكل صحيح',
            'password.exists' => 'خطاء في كلمة المرور',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if (Auth::guard('admin')->attempt(
                ['email' => $request->email,
                    'password' => $request->password,
                    'status' => 1
                ]
            ) or
            Auth::guard('admin')->attempt(
                ['phone' => $request->email,
                    'password' => $request->password,
                    'status' => 1
                ]
            )
        ) {
            $data = array(
                'user_id' => Auth::guard('admin')->id(),
                'user_type' => 'admin',
                'device_id' => get_devic_mac(),
                'device_token' => $request->device_token,
                'device_type' => 'web',
            );
            if (Auth::guard('admin')->user()->type == "seller")
                Auth::guard('admin')->user()->syncRoles(["Seller"]);
            if (isset($request->device_token) and $request->device_token != null)
                setFirBaseToken($data);
            return redirect()->intended('/admin/home');
        } elseif ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function LogoutAdmin()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function Admin_forget()
    {
        return view('auth.forgetPassword');
    }

    public function Admin_forget_check(Request $request)
    {
        $rules = [
            'name' => 'required|exists:users,name',
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
        $messages = [
            'name.exists' => 'لايوجد مستخدم بهذا الاسم',
            'email.exists' => 'لايوجد مستخدم بهذا الايميل',
            'password.exists' => 'خطاء في كلمة المرور',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Admin = Admin::where('name', $request->name);
        if ($Admin) {
            $Admin->update(['password' => bcrypt($request->password)]);
            if ($Admin) {
                return redirect()->route('admin.login');
            } else {
                return redirect()->back()->withErrors($Admin)->withInput();
            }
        }
    }

}
