<?php

namespace App\Http\Controllers;

use App\Admin;
use App\ShareUser;
use App\User;

class FrontSharedUserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $post = User::with('share_user')->where('status', 0)->where('type', 'share_users')->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right">موافقة</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">رفض</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('shareduser.index', compact(['admin']));
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
            User::where('id', $id)->restore();
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
        $admin = Admin::where('id', 1)->first();
        return view('shareduser.agree', compact(['admin']));
    }

    ########################################## trashed users

    public function trashedUsers()
    {
        if (request()->ajax()) {
            $post = User::onlyTrashed()->with('share_user')->where('type', 'share_users')->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="show" id="' . $data->id . '" class="show btn btn-info btn-sm "style="float: right">إستعادة</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">حذف نهائي</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('shareduser.trashed', compact(['admin']));
    }
}
