<?php

namespace App\Traits;


trait AuthTrait
{
################################ Register
    public function Register_Rules()
    {
        return [
            "name" => "required",
            "phone" => "required|numeric|digits:9|starts_with:77,73,74,70,71|unique:users,phone",
            "password" => "required|string|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
//            "password_confirm" => "required|same:password",
        ];
    }

    public function Register_messages()
    {
        return [
            "name.required" => "يرجى كتابة اسم المستخدم",
            "phone.required" => "يرجى كتابة رقم الهاتف",
            "phone.numeric" => "رقم الهاتف يجب ان يكون ارقام فقط ",
            "phone.digits" => "يجب ان يكون رقم الهاتف 9 ارقام",
            "phone.starts_with" => "قم بكتابة رقم هاتفك الشخصي",
            "phone.unique" => "يوجد  مستخدم مسجل بهذا الرقم ",
            "password.required" => "قم بكتابة الباسوورد",
            "password.string" => "كلمة المرور يجب ان تكون قوية تحتوي على ارقام وحروف انجليزية كبتل واسمول ورموز",
            "password.min" => "كلمة المرور يجب ان تكون 10 ارقام وحروف ورموز",
            "password.regex" => "كلمة المرور يجب ان تكون فيها حروف انجليزية اسمول وكبتل ورموز",
//            "password_confirm.required" => "عيد كتابة الباسوور من اجل تتاكد هو نفسه او ماشي",
//            "password_confirm.same" => "هيا شوفت قولت لك اتاكد واكتب نفس كلمة المرور اللي كتبتها",
        ];
    }

################################ Login
    public function Login_Rules()
    {
        return [
            "phone" => "required|exists:users,phone",
            "password" => "required",
            //|exists:users,password
        ];
    }

    public function Login_Messages()
    {
        return [
            "phone.required" => "يرجى كتابة رقم هاتفك بشكل صحيح",
            "phone.exists" => "لايوجد مستخدم بهذا الرقم الذي ادخلته",
            "password.required" => "قم بكتابة كلمة المرور بالشكل الصحيح",
            //"password.exists" =>"قم بكتابة كلمة المرور بالشكل الصحيح",
        ];
    }

}
