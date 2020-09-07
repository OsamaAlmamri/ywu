<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\TrainingContents\Subject;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\User;


class FrontUserController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
        if (request()->ajax()) {
            $post = User::where('type', 'visitor')->get();

            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"style="float: right">توقيف الحساب</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('user.index', compact('admin'));
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
    public function index_trashed()
    {
        if (request()->ajax()) {
            $post = User::onlyTrashed()->latest()->get();
            return datatables()->of($post)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="restore btn btn-success btn-sm" style="float: right"><span class=\'glyphicon glyphicon-log-out\'></span></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="force_delete btn btn-danger btn-sm"style="float: right"><span class=\'glyphicon glyphicon-trash\'></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $admin = Admin::where('id', 1)->first();
        return view('user.trashed', compact('admin'));
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
