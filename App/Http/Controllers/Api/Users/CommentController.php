<?php

namespace App\Http\Controllers\Api\Users;


use App\Http\Controllers\Controller;
use App\Models\UserContents\Comment;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    protected $user;
    protected $emp;
    use JsonTrait;
//    public function __construct()
//    {
//    }

    public function index()
    {
        $comment=Comment::with(['user','post'])->orderByDesc('id')->paginate(5);
        return  $this->GetDateResponse('Comments',$comment);
    }

    public function store(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "body" => "required",
                "post_id" => "required|integer",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $comment = new Comment();
            $comment->body = $request->body;
            $comment->post_id = $request->post_id;
            //$this->user->posts()->find($request->post_id) && $this->user->comments()->save($comment)
            if ($this->user->comments()->save($comment))
                return $this->GetDateResponse('comment',$comment,"تم انشاء تعليق");

            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية للتعليق على هذا المنشور');
        }catch (\Exception $ex){
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $rules = [
            "body" => "required",
        ];

        $validator = Validator::make($request->only('body'), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $comment = $this->user->comments()->find($id);

        if (!$comment) {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لتعديل هذا التعليق');
        }

        $updated = $comment->fill($request->only('body'))->save();

        if ($updated) {
            return $this->GetDateResponse('comment',$comment,"تم التعديل");
        } else {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لتعديل هذا التعليق');
        }
    }

    public function destroy($id)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $comment = $this->user->comments()->find($id);

        if (!$comment) {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لحذف هذا التعليق');
        }

        if ($comment->delete()) {
            return $this->ReturnSuccessRespons("200","تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لحذف هذا التعليق');
        }
    }
    ################################################################### replay
    public function replay(Request $request)
    {
        $this->emp = Auth::guard('employee-api')->user();
        try {
            $rules = [
                "body" => "required",
                "post_id" => "required|integer",
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $comment = new Comment();
            $comment->body = $request->body;
            $comment->post_id = $request->post_id;

            if ($this->emp->type=='استشاري'){
                if ($this->emp->comments()->save($comment)){
                    return $this->GetDateResponse('comment',$comment,"تم انشاء تعليق");
                }
            }

            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية للتعليق على هذا المنشور');
        }catch (\Exception $ex){
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }
    public function update_replay(Request $request, $id)
    {
        $this->emp = Auth::guard('employee-api')->user();
        $rules = [
            "body" => "required",
        ];

        $validator = Validator::make($request->only('body'), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $comment = $this->emp->comments()->find($id);

        if (!$comment) {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لتعديل هذا التعليق');
        }

        $updated = $comment->fill($request->only('body'))->save();

        if ($updated) {
            return $this->GetDateResponse('comment',$comment,"تم التعديل");
        } else {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لتعديل هذا التعليق');
        }
    }

    public function destroy_replay($id)
    {
        $this->emp = Auth::guard('employee-api')->user();
        $comment = $this->emp->comments()->find($id);

        if (!$comment) {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لحذف هذا التعليق');
        }

        if ($comment->delete()) {
            return $this->ReturnSuccessRespons("200","تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لحذف هذا التعليق');
        }
    }
}
