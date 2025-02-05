<?php

namespace App\Http\Controllers\Api\Users;

use App\Activaty;
use App\Http\Controllers\Controller;
use App\Models\UserContents\Category;
use App\Models\UserContents\Comment;
use App\Models\UserContents\Post;
use App\Slide;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;


class ActivatesController extends Controller
{
    use JsonTrait;

    public function index()
    {

        $news = Activaty::where('status','1')->where('type',1)->orderBy('sort')->get();
        $projects = Activaty::where('status','1')->where('type',2)->orderBy('sort')->get();
        if (!$projects and !$news) {
            return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
        } else {

            return $this->GetDateResponse('data',['news'=>$news,'projects'=>$projects]);
        }
    }

    public function slides()
    {

        $post = Slide::where('status','1')->orderBy('sort')->get();
        if (!$post) {
            return $this->ReturnErorrRespons('0000', 'لايوجد سلايدات ');
        } else {
            return $this->GetDateResponse('data', $post);
        }
    }


}
