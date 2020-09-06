<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    use PostTrait;

    public function Admin(){
        return redirect()->route('home');
    }
    public function Admin_login(){
        return view('auth.login_1');
    }

    public function adminLoginCheck(Request $request){
        $rules=[
            'email' => 'required|email|exists:admins,email',
            'password'=>'required|exists:admins',
        ];
        $messages=[
            'email.exists' => 'قم بادخال الايميل بشكل صحيح',
            'password.exists' => 'خطاء في كلمة المرور',
        ];

        $validator= Validator::make($request->all(), $rules,$messages);

        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect()->intended('/admin');
        }
        elseif($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    public function LogoutAdmin(){
        Auth::logout();
        return redirect()->route('Admin_login');
    }

    public function Admin_forget(){
        return view('auth.forgetPassword');
    }

    public function Admin_forget_check(Request $request){
        $rules=[
            'name' => 'required|exists:admins,name',
            'email' => 'required|email|exists:admins,email',
            'password'=>'required',
        ];
        $messages=[
            'name.exists' => 'لايوجد مستخدم بهذا الاسم',
            'email.exists' => 'لايوجد مستخدم بهذا الايميل',
            'password.exists' => 'خطاء في كلمة المرور',
        ];

        $validator= Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Admin=Admin::where('name',$request->name);
        if($Admin){
            $Admin->update(['password'=>bcrypt($request->password)]);
            if($Admin){
                return redirect()->route('Admin_login');
            }
            else{
                return redirect()->back()->withErrors($Admin)->withInput();
            }
        }
    }

    public function Update_Admin_Details(){
        $admin=Admin::all();
        return view('auth.update',compact('admin'));
    }

    public function Admin_update(Request $request){
        $rules=[
            'name' => 'required',
            'email' => 'required|email',
            'image'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ];
        $messages=[
            'name.required' => 'قم بكتابة اسم المستخدم',
            'email.required' => 'يرجى كتابة الايميل',
        ];

        $validator= Validator::make($request->all(), $rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Admin=Admin::where('id',$request->id)->first();
        if($Admin){
            if($request->image!=null){
                $Admin->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'image'=>$this->Post_update($request,'image',"IMG-",'assets/images/',$Admin->image)
                ]);
                if($Admin){
                    return redirect()->route('home');
                }
                else{
                    return redirect()->back()->withErrors($Admin)->withInput();
                }
            }
            else{
                $Admin->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                ]);
                if($Admin){
                    return redirect()->route('home');
                }
                else{
                    return redirect()->back()->withErrors($Admin)->withInput();
                }
            }
        }
    }
}
