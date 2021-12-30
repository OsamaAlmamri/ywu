<?php

namespace App\Http\Controllers\Api2\Consultants;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Http\Resources\Consultant\CommentForewordConsultantResource;
use App\Http\Resources\Consultant\CommentsConsultantPostResource;
use App\Http\Resources\Consultant\ForewordConsultantResource;
use App\Http\Resources\Consultant\ForewordConsultantWithPostResource;
use App\Http\Resources\General\UserSelectResource;
use App\Models\UserContents\Post;
use App\Models\V2\UserContents\Consultant;
use App\Models\V2\UserContents\ForewordComment;
use App\Models\V2\UserContents\ForewordConsultant;
use App\Notifications\AppNotification;
use App\Traits\JsonTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ForwordConsultantController extends Controller
{
    protected $user;
    use JsonTrait;

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        $limit = (request()->limit != null) ? request()->limit : 20;
        $category = request()->category;
        $type = request()->type;
//        $user = JWTAuth::user();
        $post = ForewordConsultant::where('foreword_to', $this->user->id)
            ->orderBy('id', 'desc')->paginate($limit);

        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لايوجد استشارات');
        } else {
            ForewordConsultantResource::collection($post);
            return $this->GetDateResponse('data', $post);
        }
    }


    public
    function forewordConsultantUsers()
    {
        $users = User::ofPermission(['foreword consultant'])->get();
        $users = UserSelectResource::collection($users);

        return $this->GetDateResponse('data', $users);

    }


    public function forewordToUsers(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "post_id" => "required|integer",
                "foreword_to" => "required|integer",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = ForewordConsultant::UpdateOrCreate(['post_id' => $request->post_id, 'foreword_to' => $request->foreword_to], [
                'post_id' => $request->post_id,
                'note' => $request->note,
                "foreword_by" => $this->user->id,
            ]);
            $message = 'هناك استشارة جديدة تمت احالتها بواسطة   ' . $this->user->name;
            $dataToNotification = array(
                'sender_name' => auth()->user()->name,
                'order_id' => $post->id,
                'notification_type' => "new_post",
                'user_id' => \auth()->id(),
                'sender_image' => url('site/images/Logo250px.png'),
                'message' => $message,
                'date' => $post->created_at
            );
            $admins_id = [];
            $admins_id[] = $request->foreword_to;
            $admins = getAdminsOrderNotifucation('foreword');
            foreach ($admins as $admin) {
                $admins_id[] = $admin->id;
                $admin->notify(new AppNotification($dataToNotification));
            }
            $tokens = getNotifiableUsers(0, $admins_id);
            $this->firbaseContoller->multi($tokens, $dataToNotification);

            return $this->GetDateResponse('data', new ForewordConsultantResource ($post), "تم اعادة توجية  الاستشارة بنجاح ");

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


    public function update(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "solve" => "required",
                "status" => "required",
                "id" => "required|integer",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = ForewordConsultant::find($request->id);
            if ($post == null or $this->user->id != $post->foreword_to)
                return $this->ReturnErorrRespons("400", $this->user->id);
            $post->update([
                'solve' => $request->solve,
                'status' => $request->status
            ]);
            return $this->GetDateResponse('data', new ForewordConsultantResource($post), "تم نشر استشارتك");

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


    public function storeComment(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "date" => "required",
                "body" => "required",
                "foreword_id" => "required|integer",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = ForewordConsultant::find($request->foreword_id);
            if ($post == null or $this->user->id != $post->foreword_to)
                return $this->ReturnErorrRespons("400", "ليس لديك الصلاحية");

            $post = ForewordComment::updateOrCreate(['id' => $request->id, 'user_id' => $this->user->id], [
                'date' => $request->date,
                'body' => $request->body,
                "foreword_id" => $request->foreword_id,
                'user_id' => $this->user->id,
            ]);
            return $this->GetDateResponse('data', new CommentForewordConsultantResource($post), "تم نشر استشارتك");

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


    public function deleteComment($id)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $post = ForewordComment::where('id', $id)->where('user_id', $this->user->id);
        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية للحذف ');
        }

        if ($post->delete()) {
            return $this->ReturnSuccessRespons("200", "تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية للحذف  ');
        }
    }


}
