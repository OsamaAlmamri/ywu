<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductsAttribute;
use App\Models\Shop\Zone;
use App\Rules\MatchOldPassword;
use App\ShareUser;
use App\Traits\AuthTrait;
use App\Traits\JsonTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ZoneController extends Controller
{
    use JsonTrait;

    public
    function get_gov(Request $request)
    {
        $data = Zone::where('parent', 0)->get(['id', 'name_en', 'name_ar']);
//        $data = Zone::with(['childZone:id,name_en,name_ar,parent'])->where('parent', 0)->get(['id', 'name_en', 'name_ar']);

        return $this->GetDateResponse('data', $data);
    }

    public
    function upload_image(Request $request)
    {
        try {
            $image = saveImage('images/sellers/', $request->file('file'));
            return $this->GetDateResponse('data', $image);
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public
    function get_district(Request $request)
    {
        $data = Zone::where('parent', $request->gov_id)->get(['id', 'name_en', 'name_ar']);
        return $this->GetDateResponse('data', $data);
    }


    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);
        if (!$user) {
            return $this->ReturnErorrRespons('0000', 'يرجى تسجيل الدخول اولا');
        } elseif ($user->type == 'share_users') {
            $user->share_user = $user->share_user;
        } elseif ($user->type == 'employees') {
            $user->branch = $user->employee->branch;
            $user->department = $user->employee->department;
            $user->job = $user->employee->department;
        }
        return $this->GetDateResponse('user', $user);
    }

    public
    function Update_User_Details(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user) {
            $user->name = request()->name;
            $user->update();
            return $this->GetDateResponse('user', $user);
        } else {
            return $this->ReturnSuccessRespons("200", "قم بتسجيل الدخول");
        }
    }

    public
    function update_profile(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user) {
            $user->name = request()->name;
            $user->phone = request()->phone;
            $user->email = request()->email;
            $user->update();
            return $this->GetDateResponse('user', $user);
        } else {
            return $this->ReturnSuccessRespons("200", "قم بتسجيل الدخول");
        }
    }


    public
    function Reset_User_Password(Request $request)
    {
        if (User::where('id', request()->id)->first()) {
            $rules = ([
                "id" => "required",
                "phone" => "required|exists:users,phone",
                "password" => "required|string|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            ]);
            $messages = ([
                "phone.required" => "يرجى إدخال رقم الهاتف",
                "phone.exists" => "رقم الهاتف الذي ادخلته غير صحيح",
                "password.required" => "يرجى ادخال كلمة المرور الجديدة",
                "password.min" => "كلمة المرور يجب ان تكون 10 ارقام وحروف ورموز",
                "password.regex" => "كلمة المرور يجب ان تحتوي على حروف انجليزية اسمول وكبتل ورموز",
            ]);
            $validator = Validator::make($request->only('phone', 'password', 'id'), $rules, $messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = User::where('id', request()->id)->where('phone', request()->phone)->first();
            if ($user) {
                $user->password = bcrypt(request()->password);
                $user->update();

                return $this->GetDateResponse('user', $user);
            } else {
                return $this->ReturnSuccessRespons("200", "تاكد من رقم الهاتف");
            }
        } else {
            return $this->ReturnSuccessRespons("200", "حدث خطاء ");
        }
    }
}
