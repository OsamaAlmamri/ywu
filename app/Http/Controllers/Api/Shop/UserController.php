<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductsAttribute;
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

class UserController extends Controller
{
    public $loginAfterSignUp = true;
    use JsonTrait;
    use AuthTrait;

    public function register(Request $request)
    {
        try {
            if ($request->userType == 'visitor')
                $request->email = null;
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "phone" => "required|unique:users,phone",
                "email" => "nullable|email|unique:users,email",
                "password" => "required|string|min:4",
                'userType' => 'required',
                'share_user_type' => 'required_if:userType,share_user',
                'destination' => 'required_if:userType,share_user',
            ], [
                "name.required" => "يرجى كتابة اسم المستخدم",
                "phone.required" => "يرجى كتابة رقم الهاتف",
                "phone.numeric" => "رقم الهاتف يجب ان يكون ارقام فقط ",
                "phone.digits" => "يجب ان يكون رقم الهاتف 9 ارقام",
                "phone.starts_with" => "قم بكتابة رقم هاتفك الشخصي",
                "phone.unique" => "يوجد  مستخدم مسجل بهذا الرقم ",
                "password.required" => "قم بكتابة الباسوورد",
                "password.string" => "كلمة المرور يجب ان تكون قوية تحتوي على ارقام وحروف انجليزية كبتل واسمول ورموز",
                "password.min" => "كلمة المرور يجب ان تكون 4 ارقام وحروف ورموز",
            ]);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
                return $this->returnValidationError($code, $request->all());
            }
            $oldPass = $request['password'];
            $request['password'] = bcrypt($request->password);
            if ($request->userType == 'share_user') {
                $user = User::create(array_merge($request->all(), ['type' => 'share_users', 'status' => 0]));
                ShareUser::create(['user_id' => $user->id, 'type' => $request->share_user_type, 'destination' => $request->destination]);
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->gender = $request->gender;
                $user->password = $request->password;
                $user->type = 'visitor';
                $user->save();

            }
            $request['password'] = $oldPass;

            if ($this->loginAfterSignUp) {
                return $this->login($request, 1);
            }
            return $this->GetDateResponse('data', $user);

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function login(Request $request, $fromRegister = 0)
    {

        try {
            $validator = Validator::make($request->all(), [
                "phone" => "required",
                "password" => "required",
            ]);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credential_email = ['email' => $request->phone, 'password' => $request->password];
            $credential_phone = ['phone' => $request->phone, 'password' => $request->password];
            $jwt_token = null;
            if ($jwt_token = JWTAuth::attempt($credential_email) or $jwt_token = JWTAuth::attempt($credential_phone)) {
                $user = JWTAuth::user();
                if ($user->status == 1) {
                    if ($user->type == 'share_users') {
                        $user->share_user = $user->share_user;
                    } elseif ($user->type == 'employees') {
                        $user->branch = $user->employee->branch;
                        $user->department = $user->employee->department;
                        $user->job = $user->employee->department;
                    }
                    return $this->GetDateResponse('data', ['token' => $jwt_token, 'userData' => $user]);
                }
                if ($fromRegister == 1)
                    return $this->GetDateResponse('data', 0, ' تم التسجيل بنجاح وسيتم تفعيل حسابك لاحقا ');
                else
                    return $this->ReturnErorrRespons('0000', 'تم ايقاف حسابك مؤقتا');
            } else
                return $this->ReturnErorrRespons('0000', 'تاكد من كلمة المرور');
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());
        }

    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);
            return $this->ReturnSuccessRespons("200", "تم تسجيل الخروج بنجاح");
        } catch (JWTException $exception) {
            return $this->ReturnErorrRespons('0000', 'لايمكن تسجيل الخروج');
        }
    }

    public function info()
    {
        $p = ProductsAttribute::with('product_option')->get();

        return $this->ReturnSuccessRespons("200", $p);

    }

    public
    function changePassword(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $match = new MatchOldPassword;
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', $match],
            'new_password' => ['required'],
        ], [
//                'current_password.required' => 'كلمة  المرور الحالية مطلوبة',
            'new_password.required' => 'كلمة  المرور الجديدة مطلوبة',
            'new_confirm_password.same' => 'كلمة  المرور الجديدة غير متطابقة ',
        ]);
        if ($validator->fails()) {
            return $this->ReturnErorrRespons('0000', $validator->errors());

        }
        $user->update(['password' => Hash::make($request->new_password)]);
        return $this->GetDateResponse('data', 1, 'تم تغيير كلمة المرور بنجاح ');

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
