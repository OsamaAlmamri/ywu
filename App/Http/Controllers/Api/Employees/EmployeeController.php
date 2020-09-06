<?php

namespace App\Http\Controllers\Api\Employees;

use App\Http\Controllers\Controller;
use App\Employee;
use App\Traits\AuthTrait;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;


class EmployeeController extends Controller
{
    public $loginAfterSignUp = true;
    use JsonTrait;
    use AuthTrait;

    public function register(Request $request)
    {   try {
        $rules = [
            "name" => "required",
            "email"=>"required|email|unique:employees,email",
            "password" => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $emp = new Employee();
        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->password = bcrypt($request->password);
        $emp->category_id=$request->category_id;
        $emp->save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }
        return  $this->GetDateResponse('data',$emp);

    }catch (\Exception $ex){
        return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
    }
    }

    public function login(Request $request)
    {
        $rules = [
            "email"=>"required|email|exists:employees,email",
            "password" => "required",
        ];
        $messages=[
            "email.required"=>"يرجى كتابة ايميل المستخدم",
            "email.email"=>"قم بادخال الايميل بشكل صحيح",
            "email.exists"=>"لايوجد مستخدم بهذا الايميل الذي ادخلته",
        ];
        $validator = Validator::make($request->only('email', 'password'), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        try {
            $user=Employee::where('email',$request->email)->first();
            if($user->email==$request->email){
                $input = $request->only('email','password');
                $jwt_token = null;
                if (!$jwt_token = Auth::guard('employee-api')->attempt($input)) {
                    return $this->ReturnErorrRespons('0000','تاكد من كلمة المرور');
                }
                return  $this->GetDateResponse('token',$jwt_token);
            }
        }catch (\Exception $ex){
            return $this->ReturnErorrRespons('0000','تم ايقاف حسابك مؤقتا');
        }
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            Auth::guard('employee-api')->invalidate($request->token);
            return  $this->ReturnSuccessRespons("200","تم نسجيل الخروج بنجاح");
        } catch (JWTException $exception) {
            return $this->ReturnErorrRespons('0000','لايمكن تسجيل الخروج');
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $emp = Auth::guard('employee-api')->user()->with('category')->where('id',$request->id)->get();
        return  $this->GetDateResponse('user',$emp);
    }

    public function Update_Employee_Details(Request $request)
    {
        if (Employee::where('id',request()->id)->first()) {
            $rules =([
                "id" => "required",
                "name" => "required",
            ]);
            $messages=([
                "name.required"=>"يرجى إدخال اسم المستخدم الجديد",
            ]);
            $validator = Validator::make($request->only('name','id'), $rules,$messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = Employee::where('id',request()->id)->first();
            if($user ){
                $user->name = request()->name;
                $user->update();

                return $this->GetDateResponse('user', $user);
            }
            else{
                return  $this->ReturnSuccessRespons("200","قم بتسجيل الدخول");
            }
        }
        else{
            return  $this->ReturnSuccessRespons("200","حدث خطاء ");
        }
    }

    public function Reset_Employee_Password(Request $request)
    {
        if (Employee::where('id',request()->id)->first()) {
            $rules =([
                "id" => "required",
                "email" => "required|exists:employees,email",
                "password" => "required|string|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            ]);
            $messages=([
                "email.required"=>"يرجى إدخال الايميل بشكل صحيح",
                "email.exists"=>"الايميل الذي ادخلته غير صحيح",
                "password.required"=>"يرجى ادخال كلمة المرور الجديدة",
                "password.min" => "كلمة المرور يجب ان تكون 10 ارقام وحروف ورموز",
                "password.regex" => "كلمة المرور يجب ان تحتوي على حروف انجليزية اسمول وكبتل ورموز",
            ]);
            $validator = Validator::make($request->only('email','password','id'), $rules,$messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = Employee::where('id',request()->id)->where('email',request()->email)->first();
            if($user ){
                $user->password = bcrypt(request()->password);
                $user->update();

                return $this->GetDateResponse('user', $user);
            }
            else{
                return  $this->ReturnSuccessRespons("200","تاكد من رقم الهاتف");
            }
        }
        else{
            return  $this->ReturnSuccessRespons("200","حدث خطاء ");
        }
    }
}
