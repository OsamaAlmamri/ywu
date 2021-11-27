<?php

namespace App\Http\Controllers\Api2\Consultants;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Http\Resources\Consultant\ConsultantPostResource;
use App\Models\V2\UserContents\Consultant;
use App\Traits\JsonTrait;
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
    function myPosts()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
            $mPosts = $this->user->posts()->where('status', true)
                ->with(['category', 'comments'])
                ->get(['id', 'title', 'body', 'user_id', 'category_id', 'status', 'favorite', 'created_at', 'updated_at'])->toArray();
            if (!$mPosts) {
                return $this->ReturnErorrRespons('0000', 'لايوجد استشارات');
            } else {
                return $this->GetDateResponse('Posts', $mPosts);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons('0000', 'تم ايقاف حسابك مؤقتا');
        }

    }

    public
    function myPosts_pages()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
            $posts = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('user_id', auth()->id())
//                ->where('category_id', request()->category)
                ->orderBy('id', 'desc')->paginate(5);

            if (!$posts) {
                return $this->ReturnErorrRespons('0000', 'لايوجد إستشارات');
            } else {
                return $this->GetDateResponse('data', $posts);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons('0000', 'تم ايقاف حسابك مؤقتا');
        }

    }

    public
    function show($id)
    {
        $post = $this->user->posts()->find($id);
        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لرؤية هذا المنشور');
        } else {
            return $this->GetDateResponse('Post', $post);
        }
    }

}
