<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Models\UserContents\Post;
use App\Traits\JsonTrait;


class PostController extends Controller
{
    protected $user;
    use JsonTrait;

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
    }

    public function index()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        $limit = (request()->limit != null) ? request()->limit : 20;
        if (request()->category != null) {
            $post = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('status', true)
                ->where('category_id', request()->category)
                ->orderBy('id', 'desc')->paginate($limit);
            if (!$post) {
                return $this->ReturnErorrRespons('0000', 'لايوجد استشارات');
            } else {
                return $this->GetDateResponse('Posts', $post);
            }
        } else {
            $post = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('status', true)
                ->orWhere('user_id', $user_id)
                ->orderBy('id', 'desc')->paginate($limit);
            if (!$post) {
                return $this->ReturnErorrRespons('0000', 'لايوجد استشارات');
            } else {
                return $this->GetDateResponse('Posts', $post);
            }
        }
    }

}
