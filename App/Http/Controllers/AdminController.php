<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Employee;
use App\Models\TrainingContents\Subject;
use App\Models\TrainingContents\Training;
use App\Models\UserContents\Category;
use App\Models\UserContents\Comment;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\ShareUser;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $shareduser = ShareUser::all()->where('status', 'مفعل')->count();
        $admin = Admin::where('id', 1)->first();
        $users = User::all()->count();
        $employees = Employee::all()->count();
        $subjects = Subject::all()->count();
        $trainings = Training::all()->count();
        $pos = Post::all()->count();
        $pos_agree = Post::all()->where('status', true)->count();
        $women = WomenPosts::all()->count();
        $soft_delete = Post::onlyTrashed()->count();
        $posts = Post::with(['user', 'category'])->where('status', false)->orderBy('id', 'desc')->paginate(5);

        return view('asking.index', compact(['shareduser', 'admin', 'trainings', 'subjects', 'posts', 'soft_delete', 'pos_agree', 'users', 'pos', 'employees', 'women']));
    }

    public function restore(Request $request)
    {
        if ($request->id) {
            Post::where('id', $request->id)->restore();
            return response()->json(['id' => $request->id]);
        }
    }

    public function force(Request $request)
    {
        if ($request->id) {
            Post::where('id', $request->id)->forceDelete($request->id);
            return response()->json(['id' => $request->id]);
        }
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['status' => true, 'message' => "تم رفض العناصر بنجاح."]);
    }

    public function forceMultiple(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->forceDelete($request->id);
        return response()->json(['status' => true, 'message' => "تم حذف العناصر بنجاح."]);
    }

    public function restoreMultiple(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id', explode(",", $ids))->restore();
        return response()->json(['status' => true, 'message' => "تم استعادة العناصر بنجاح."]);
    }

    public function update_multi(Request $request)
    {
        $ids = $request->ids;
        $post = Post::whereIn('id', explode(",", $ids));
        if ($post) {
            $post->update(['status' => true]);
            return response()->json(['status' => true, 'message' => "تم موافقة العناصر بنجاح."]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطاؤ ',
            ]);
        }
    }

    public function show()
    {
        if (request()->category != null) {
            $posts = Post::with(['user', 'category'])
                ->where('status', true)
                ->where('category_id', request()->category)
                ->orderBy('id', 'desc')->paginate(5);
            $comments = Comment::with(['user', 'post'])->get();
            $categories = Category::all();
            $users = User::withTrashed()->get();
            $admin = Admin::where('id', 1)->first();
            return view('asking.show', compact(['admin', 'posts', 'comments', 'categories', 'users']));
        } elseif (request()->user != null) {
            $posts = Post::with(['user', 'category'])
                ->where('status', true)
                ->where('user_id', request()->user)
                ->orderBy('id', 'desc')->paginate(5);
            $comments = Comment::with(['user', 'post'])->get();
            $categories = Category::all();
            $users = User::withTrashed()->get();
            $admin = Admin::where('id', 1)->first();
            return view('asking.show', compact(['admin', 'posts', 'comments', 'categories', 'users']));
        } elseif (request()->user != null and request()->category != null) {
            $posts = Post::with(['user', 'category'])
                ->where('status', true)
                ->where('category_id', request()->category)
                ->orwhere('user_id', request()->user)
                ->orderBy('id', 'desc')->paginate(5);
            $comments = Comment::with(['user', 'post'])->get();
            $categories = Category::all();
            $users = User::withTrashed()->get();
            $admin = Admin::where('id', 1)->first();
            return view('asking.show', compact(['admin', 'posts', 'comments', 'categories', 'users']));
        } else {
            $posts = Post::with(['user', 'category'])
                ->where('status', true)
                ->orderBy('id', 'desc')->paginate(5);
            $comments = Comment::with(['user', 'post'])->get();
            $categories = Category::all();
            $users = User::withTrashed()->get();
            $admin = Admin::where('id', 1)->first();
            return view('asking.show', compact(['admin', 'posts', 'comments', 'categories', 'users']));
        }
    }

    function fetch(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with(['user', 'category'])
                ->where('status', false)
                ->orderBy('id', 'desc')
                ->paginate(5);
            $admin = Admin::where('id', 1)->first();
            return view('asking.fetch', compact(['posts', 'admin']))->render();
        }
    }

    #################################################
    public function update(Request $request)
    {
        $post = Post::with('user')->find($request->id);
        if (empty($post->user->name)) {
            return response()->json([
                'status' => false,
                'mag' => 'لايمكن قبول منشورات',
                'id' => $request->id,
            ]);
        } else {
            if ($post) {
                $post->status = true;
                $post->update();
                return response()->json([
                    'status' => true,
                    'mag' => 'تم الحذف بنجاح',
                    'id' => $request->id,
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'حدث خطاؤ ',
                ]);
            }
        }
    }

    public function destroy(Request $request)
    {
        if ($request->id) {
            Post::destroy(request('id'));
            return response()->json([
                'status' => true,
                'mag' => 'تم الرفض',
                'id' => $request->id,
            ]);
            //return response()->json(['id'=>$request->id]);
        }
    }

    function deletedPost(Request $request)
    {
        $soft_delete = Post::onlyTrashed()->with(['user', 'category'])->orderBy('id', 'desc')->paginate(5);
        $admin = Admin::where('id', 1)->first();
        return view('asking.trashed', compact(['soft_delete', 'admin']))->render();
    }

    public function comment_D(Request $request)
    {
        if ($request->id) {
            Comment::destroy(request('id'));
            return response()->json(['id' => $request->id]);
        }
    }
}
