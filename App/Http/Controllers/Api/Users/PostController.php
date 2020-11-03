<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\UserContents\Category;
use App\Models\UserContents\Comment;
use App\Models\UserContents\Post;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    protected $user;
    use JsonTrait;


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

    public function myPosts()
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

    public function myPosts_pages()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
            $posts = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('user_id', auth()->id())
//                ->where('category_id', request()->category)
                ->orderBy('id', 'desc')->paginate(5);

            if (!$posts) {
                return $this->ReturnErorrRespons('0000', 'لايوجد استشارات');
            } else {
                return $this->GetDateResponse('data', $posts);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons('0000', 'تم ايقاف حسابك مؤقتا');
        }

    }

    public function show($id)
    {
        $post = $this->user->posts()->find($id);
        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك صلاحية لرؤية هذا المنشور');
        } else {
            return $this->GetDateResponse('Post', $post);
        }
    }

    public function store(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "title" => "required",
                "body" => "required",
                "category_id" => "required|integer",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
                "category_id" => $request->category_id,
                'status' => 0,
                'user_id' => $this->user->id,
            ]);
            $post = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('id', $post->id)->get()->first();
            return $this->GetDateResponse('data', $post, "تم نشر استشارتك");

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function store_post(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "title" => "required",
                "body" => "required",
                "category_id" => "required|integer",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
                "category_id" => $request->category_id,
                'status' => 0,
                'user_id' => $this->user->id,
            ]);
            $post = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('id', $post->id)->get()->first();
            return $this->GetDateResponse('data', $post, "تم نشر استشارتك");

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function update_post_web(Request $request)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        try {
            $rules = [
                "id" => "required",
                "title" => "required",
                "body" => "required",
                "category_id" => "required|integer",
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = Post::find($request->id);
            $post = $post->update([
                'title' => $request->title,
                'body' => $request->body,
                "category_id" => $request->category_id,
            ]);
            $post = Post::with(['user', 'category', 'comments', 'user_like'])
                ->where('id', $request->id)->get()->first();
            return $this->GetDateResponse('data', $post, " تم تحديث استشارتك بنجاح");

        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $rules = [
            "title" => "required",
            "body" => "required",
        ];

        $validator = Validator::make($request->only('body', 'title'), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $post = $this->user->posts()->find($id);

        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لتعديل هذا المنشور');
        }

        $updated = $post->fill($request->only('body', 'title'))->save();

        if ($updated) {
            return $this->GetDateResponse('post', $post, "تم التعديل");
        } else {
            return $this->ReturnErorrRespons('0000', 'حدث خطاء غير متوقع');
        }
    }

    public function destroy($id)
    {
        $this->user = JWTAuth::parseToken()->authenticate();
        $post = $this->user->posts()->find($id);

        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنشور');
        }

        if ($post->delete()) {
            return $this->ReturnSuccessRespons("200", "تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنشور');
        }
    }

    #################################### category
    public function all_category()
    {
        $categories = Category::all();
        return $this->GetDateResponse('categories', $categories);
    }

    public function search_category()
    {

        $categories = Category::all();
        return $this->GetDateResponse('categories', $categories);
    }

}
