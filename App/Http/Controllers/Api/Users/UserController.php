<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\JsonTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public $loginAfterSignUp = true;
    use JsonTrait;
    use AuthTrait;

    public function register(Request $request)
    {   try {

        $rules=$this->Register_Rules();
        $messages=$this->Register_messages();
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }
        return  $this->GetDateResponse('data',$user);

        }catch (\Exception $ex){
        return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
      }
    }

    public function login(Request $request)
    {
        $rules =$this->Login_Rules();
        $messages =$this->Login_Messages();
        $validator = Validator::make($request->only('phone','password'), $rules,$messages);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        try {
            $user=User::where('phone',$request->phone)->first();
            if($user->phone==$request->phone){
                $input = $request->only('phone','password');
                $jwt_token = null;
                if (!$jwt_token = JWTAuth::attempt($input)) {
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
            JWTAuth::invalidate($request->token);
            return  $this->ReturnSuccessRespons("200","تم تسجيل الخروج بنجاح");
        } catch (JWTException $exception) {
            return $this->ReturnErorrRespons('0000','لايمكن تسجيل الخروج');
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);
        return  $this->GetDateResponse('user',$user);
    }

    public function Update_User_Details(Request $request)
    {
        if (User::where('id',request()->id)->first()) {
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

            $user = User::where('id',request()->id)->first();
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

    public function Reset_User_Password(Request $request)
    {
        if (User::where('id',request()->id)->first()) {
            $rules =([
                "id" => "required",
                "phone" => "required|exists:users,phone",
                "password" => "required|string|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            ]);
            $messages=([
                "phone.required"=>"يرجى إدخال رقم الهاتف",
                "phone.exists"=>"رقم الهاتف الذي ادخلته غير صحيح",
                "password.required"=>"يرجى ادخال كلمة المرور الجديدة",
                "password.min" => "كلمة المرور يجب ان تكون 10 ارقام وحروف ورموز",
                "password.regex" => "كلمة المرور يجب ان تحتوي على حروف انجليزية اسمول وكبتل ورموز",
            ]);
            $validator = Validator::make($request->only('phone','password','id'), $rules,$messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user = User::where('id',request()->id)->where('phone',request()->phone)->first();
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
