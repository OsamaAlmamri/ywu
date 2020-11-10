<?php

namespace App\Http\Controllers\AdminControllers;
use App\Admin;
use App\Http\Controllers\Controller;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AdminsController extends Controller
{
    use PostTrait;

    public function Admin()
    {
        return redirect()->route('home');
    }



    public function Update_Admin_Details()
    {
        $admin = Admin::all();
        return view('auth.update', compact('admin'));
    }

    public function Admin_update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ];
        $messages = [
            'name.required' => 'قم بكتابة اسم المستخدم',
            'email.required' => 'يرجى كتابة الايميل',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Admin = Admin::where('id', $request->id)->first();
        if ($Admin) {
            if ($request->image != null) {
                $Admin->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'image' => $this->Post_update($request, 'image', "IMG-", 'assets/images/', $Admin->image)
                ]);
                if ($Admin) {
                    return redirect()->route('home');
                } else {
                    return redirect()->back()->withErrors($Admin)->withInput();
                }
            } else {
                $Admin->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                if ($Admin) {
                    return redirect()->route('home');
                } else {
                    return redirect()->back()->withErrors($Admin)->withInput();
                }
            }
        }
    }
}
