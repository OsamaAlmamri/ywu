<?php

namespace App\Http\Controllers\Api\Women;

use App\Http\Controllers\Controller;
use App\Models\WomenContents\WomenPosts;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function __construct()
    {
    }

    public function index()
    {
        // $limit=(request()->limit != null)?request()->limit:20;
        $limit=20;

        $post = WomenPosts::with(['user_like'])
            ->ofLang(\request()->header('lang','ar'))->orderByDesc('id')->paginate($limit);
        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
        } else {
            return $this->GetDateResponse('Posts', $post);
        }
    }

    public function show($id)
    {
        $post = WomenPosts::whereId($id)->first();
        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك صلاحية لرؤية هذا المنشور');
        } else {
            return $this->GetDateResponse('Post', $post);
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = $this->Post_Rules();
            $messages = $this->Post_Messages();
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $post = new WomenPosts();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->category_id = $request->category_id;
            $post->image = $this->Post_Save($request, 'image', "IMG-", 'assets/images');
            $post->book = $this->Post_Save($request, 'book', "BOK-", 'assets/books');
            $post->sound = $this->Post_Save($request, 'sound', "AUD-", 'assets/sounds');
            if ($request->video_url == null)
                $post->video_url = null;
            $post->video_url = $request->video_url;
            $post->save();
            if ($post->save())
                return $this->GetDateResponse('post', $post, "تم نشر");
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $rules = $this->Post_Rules();
        $messages = $this->Post_Messages();
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $post = WomenPosts::whereId($id)->first();
        if ($post) {
            $post->title = $request->title;
            $post->body = $request->body;
            $post->category_id = $request->category_id;
            $post->image = $this->Post_update($request, 'image', "IMG-", 'assets/images', $post->image);
            $post->book = $this->Post_update($request, 'book', "BOK-", 'assets/books', $post->book);
            $post->sound = $this->Post_update($request, 'sound', "AUD-", 'assets/sounds', $post->sound);
            if ($post->video_url != null || $post->video_url == null && $request->video_url != null) {
                $post->video_url = $request->video_url;
            } else {
                $post->video_url = null;
            }
            $post->update();
            if ($post) {
                return $this->GetDateResponse('post', $post, "تم التعديل");
            } else {
                return $this->ReturnErorrRespons('0000', 'حدث خطاء غير متوقع');
            }
        }
    }

    public function destroy($id)
    {
        $post = WomenPosts::whereId($id)->first();
        if ($post) {
            $this->Post_delete('assets/images/', $post->image);
            $this->Post_delete('assets/books/', $post->book);
            $this->Post_delete('assets/sounds/', $post->sound);
        }
        if ($post->delete()) {
            return $this->ReturnSuccessRespons("200", "تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنشور');
        }
    }
}
