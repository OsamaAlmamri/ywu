<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestLoginRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[ا-ي]/",
            "phone" => "required|numeric|digits:9|starts_with:77,73,74,70,71|unique:users,phone",
            "password" => "required|string|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            "password_confirm" => "required|same:password",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "اكتب اسمك بغير لغاجه",
            "phone.required" => "اكتب رقم تلفونك",
            "phone.numeric" => "كشفتك بتحاول تكتب نص بتدور لك هدار هيا اكتب ارقام وقع رجال ",
            "phone.digits" => "ورجع يمهد قدك داري ان رقم التلفون يجي 9 ارقام ليش عاد الحركات",
            "phone.starts_with" => "بتكتب ارقام من راسك ياسعم ماعندراش او كيف",
            "phone.unique" => "هذا الرقم قد سجلو به سير اقطع شريحة ",
            "password.required" => "اكتب كلمة المرور من اجل جماية حسابك",
            "password.string" => "كلمة المرور ضروري تكون قوية تحتوي على ارقام وحروف انجليزية كبتل واسمول ورموز",
            "password.min" => "كلمة المرور ضروري تكون 10 ارقام وحروف ورموز",
            "password.regex" => "كلمة المرور ضروري تكون فيها حروف انجليزية اسمول وكبتل ورموز",
            "password_confirm.required" => "عيد كتابة الباسوور من اجل تتاكد هو نفسه او ماشي",
            "password_confirm.same" => "هيا شوفت قولت لك اتاكد واكتب نفس كلمة المرور اللي كتبتها",
        ];
    }
}
