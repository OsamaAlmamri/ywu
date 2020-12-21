<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\ShareUser;
use App\Traits\AuthTrait;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class SharedUserController extends Controller
{
    public $loginAfterSignUp = true;
    use JsonTrait;
    use AuthTrait;


    public function register(Request $request)
    {
        try {
            $rules = [
                "name" => "required",
                "email" => "required|email|unique:share_users,email",
                "password" => "required",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $emp = new ShareUser();
            $emp->name = $request->name;
            $emp->email = $request->email;
            $emp->password = bcrypt($request->password);
            $emp->type = $request->type;
            $emp->save();

            if ($emp) {
                return $this->ReturnSuccessRespons('200', 'تم ارسال طلبك للعضوية يرجى الانتضار حتى يتم الموافقة عليه');
            }
//        if ($this->loginAfterSignUp) {
//            return $this->login($request);
//        }
            return $this->GetDateResponse('data', $emp);

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function login(Request $request)
    {
        $rules = [
            "email" => "required|email|exists:share_users,email",
            "password" => "required",
        ];
        $messages = [
            "email.required" => "يرجى كتابة ايميل المستخدم",
            "email.email" => "قم بادخال الايميل بشكل صحيح",
            "email.exists" => "لايوجد مستخدم بهذا الايميل الذي ادخلته",
        ];
        $validator = Validator::make($request->only('email', 'password'), $rules, $messages);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        try {
            $user = ShareUser::where('email', $request->email)->first();
            if ($user->email == $request->email and $user->status == 'مفعل') {
                $input = $request->only('email', 'password');
                $jwt_token = null;
                if (!$jwt_token = Auth::guard('shared-user-api')->attempt($input)) {
                    return $this->ReturnErorrRespons('0000', 'تاكد من كلمة المرور');
                }
                return $this->GetDateResponse('token', $jwt_token);
            } else {
                return $this->ReturnErorrRespons('0000', 'يرجى الانتظار حتى يتم قبول عضوية الحساب');
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons('0000', 'تم ايقاف حسابك مؤقتا');
        }
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            Auth::guard('shared-user-api')->invalidate($request->token);
            return $this->ReturnSuccessRespons("200", "تم نسجيل الخروج بنجاح");
        } catch (JWTException $exception) {
            return $this->ReturnErorrRespons('0000', 'لايمكن تسجيل الخروج');
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $emp = Auth::guard('shared-user-api')->user();
        return $this->GetDateResponse('user', $emp);
    }

    public function Update_SharedUser_Details(Request $request)
    {
        if (ShareUser::where('id', request()->id)->first()) {
            $rules = ([
                "id" => "required",
                "name" => "required",
            ]);
            $messages = ([
                "name.required" => "يرجى إدخال اسم المستخدم الجديد",
            ]);
            $validator = Validator::make($request->only('name', 'id'), $rules, $messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = ShareUser::where('id', request()->id)->first();
            if ($user) {
                $user->name = request()->name;
                $user->update();

                return $this->GetDateResponse('user', $user);
            } else {
                return $this->ReturnSuccessRespons("200", "قم بتسجيل الدخول");
            }
        } else {
            return $this->ReturnSuccessRespons("200", "حدث خطاء ");
        }
    }

    public function Reset_SharedUser_Password(Request $request)
    {
        if (ShareUser::where('id', request()->id)->first()) {
            $rules = ([
                "id" => "required",
                "email" => "required|exists:share_users,email",
                "password" => "required|string|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            ]);
            $messages = ([
                "email.required" => "يرجى إدخال الايميل بشكل صحيح",
                "email.exists" => "الايميل الذي ادخلته غير صحيح",
                "password.required" => "يرجى ادخال كلمة المرور الجديدة",
                "password.min" => "كلمة المرور يجب ان تكون 10 ارقام وحروف ورموز",
                "password.regex" => "كلمة المرور يجب ان تحتوي على حروف انجليزية اسمول وكبتل ورموز",
            ]);
            $validator = Validator::make($request->only('email', 'password', 'id'), $rules, $messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = ShareUser::where('id', request()->id)->where('email', request()->email)->first();
            if ($user) {
                $user->password = bcrypt(request()->password);
                $user->update();

                return $this->GetDateResponse('user', $user);
            } else {
                return $this->ReturnSuccessRespons("200", "تاكد من الايميل بشكل صحيح ");
            }
        } else {
            return $this->ReturnSuccessRespons("200", "حدث خطاء ");
        }
    }
}
