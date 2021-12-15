<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Admin;
use App\Models\TrainingContents\Subject;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\User;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    use JsonTrait;
    use PostTrait;


    public function __construct()
    {
        $this->middleware('permission:show users', ['only' => ['index', 'show', 'changeType', 'index_trashed']]);
        $this->middleware('permission:manage users', ['only' => ['index_trashed', 'restore_post', 'force', 'changeType', 'changeOrder', 'destroy', 'edit', 'store', 'update', 'active']]);
        $this->middleware('permission:active users', ['only' => ['active']]);
    }


    public function index($id = 0)
    {
        $user = User::find($id);
        if ($id > 0 and $user->type == 'employees')
            return redirect(route('employee', $id));
        elseif ($id > 0 and $user->type == 'share_users')
            return redirect(route('SharedUser', $id));

        if (request()->ajax()) {
            if (request()->id == 0)
                $post = User::whereIn('type', ['visitor', 'customers'])->orderBy('id', 'desc')->get();
            else {
                $post = User::where('id', request()->id)->get();

            }
//          return  $post;
            return datatables()->of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">توقيف الحساب</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = User::where('id', 1)->first();
        return view('admin.training.user.index', compact('admin', 'id'));
    }


    public function show($id)
    {
        if (request()->ajax()) {
            $data = User::whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->status = 0;
        $data->update();
        if ($data) {
            $data->delete();
        }
    }

################################################################### deleted posts
    public function index_trashed($id = 0)
    {
        $user = User::onlyTrashed()->where('id', request()->id)->first();
        if ($id > 0 and $user->type == 'employees')
            return redirect(route('employee-trashed', $id));
        elseif ($id > 0 and $user->type == 'share_users')
            return redirect(route('SharedUserTrashed', $id));

        if (request()->ajax()) {
            $post = User::onlyTrashed()->get();
            if (request()->id == 0)
                $post = User::onlyTrashed()->where('type', 'visitor')->get();
            else {
                $post = User::onlyTrashed()->where('type', 'visitor')->where('id', request()->id)->get();

            }

            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = User::where('id', 1)->first();
        return view('admin.training.user.trashed', compact('admin', 'id'));
    }

    public function edit_trashed($id)
    {
        if (request()->ajax()) {
            $data = User::onlyTrashed()->whereId($id)->first();
            return response()->json(['data' => $data]);
        }
    }

    public function restore_post($id)
    {
        $data = User::onlyTrashed()->findOrFail($id);
        $data->status = 1;
        $data->update();
        if ($data) {
            $data->restore();
        }
    }

    public function force($id)
    {
        if ($id) {
            User::where('id', $id)->forceDelete($id);
        }
    }
}
