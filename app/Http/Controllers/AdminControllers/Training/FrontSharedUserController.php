<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Admin;
use App\ShareUser;
use App\User;
use App\Http\Controllers\Controller;

class FrontSharedUserController extends Controller
{
    public function index($id = 0)
    {
        if (request()->ajax()) {
            if (request()->id == 0 or $id == 0)
                $post = User::with('share_user')
                    ->where('type', 'share_users')
                    ->where('status', 0)

                    ->get();
            else {
                $post = User::with('share_user')
                    ->where('type', 'share_users')
                    ->where('status', 1)
                    ->where('id', request()->id)->get();
            }
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right">موافقة</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">رفض</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = User::where('id', 1)->first();
        return view('admin.training.shareduser.index', compact(['admin','id']));
    }

    public function agree($id)
    {
        $data = User::findOrFail($id);
        $data->status = 1;
        $data->update();
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->update();
        if ($data) {
            $data->delete();
        }
    }

    public function restoreUser($id)
    {
        if ($id) {
            User::onlyTrashed()->where('id', $id)->restore();
        }
    }

    public function forceUser($id)
    {
        if ($id) {
            ShareUser::where('user_id', $id)->forceDelete($id);
            User::where('id', $id)->forceDelete($id);
        }
    }

    ########################################## agree users
    public function agreeUsers()
    {
        if (request()->ajax()) {
            $post = User::with('share_user')->where('status', 1)->where('type', 'share_users')->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">إيقاف الحساب</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = User::where('id', 1)->first();
        return view('admin.training.shareduser.agree', compact(['admin']));
    }

    ########################################## trashed users

    public function trashedUsers($id=0)
    {

        if (request()->ajax()) {
            if (request()->id == 0)
                $post = User::onlyTrashed()->with('share_user')->where('type', 'share_users')->get();
            else {
                $post = User::onlyTrashed()->with('share_user')->where('type', 'share_users')->where('id', request()->id)->get();

            }

            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right">إستعادة</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">حذف نهائي</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = User::where('id', 1)->first();
        return view('admin.training.shareduser.trashed', compact(['admin','id']));
    }
}
