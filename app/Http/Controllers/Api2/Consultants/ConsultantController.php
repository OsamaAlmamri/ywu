<?php

namespace App\Http\Controllers\Api2\Consultants;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Http\Resources\Consultant\ConsultantPostResource;
use App\Http\Resources\General\UserSelectResource;
use App\Models\V2\UserContents\Consultant;
use App\Traits\JsonTrait;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConsultantController extends Controller
{
    protected $user;
    use JsonTrait;

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
    }

    public function index()
    {
        $limit = (request()->limit != null) ? request()->limit : 20;
        $category = request()->category;
        $type = request()->type;
        $post = Consultant::where('status', 1)
            ->ofCategory($category)
            ->ofType($type)
            ->orderBy('id', 'desc')->paginate($limit);

        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لايوجد استشارات');
        } else {
            ConsultantPostResource::collection($post);
            return $this->GetDateResponse('data', $post);
        }
    }


    public
    function forewordConsultantUsers()
    {
        $users = User::ofPermission(['foreword consultant'])->get();
        $users=UserSelectResource::collection($users);

        return $this->GetDateResponse('data', $users);

    }

}
