<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Admin;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\UserTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserTrainingController extends Controller
{

    public function index($id = 0)
    {
        if (request()->ajax()) {
            $post = UserTraining::with(['training', 'user'])->where('status','0');
            if (\request()->id > 0)
                $post = $post->where('training_id', $id)->get();
            else
                $post = $post->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', 'user_trinings.btn.action')
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        $trainings = Training::all();
        $admin = Admin::where('id', 1)->first();
        return view('admin.training.user_trinings.show', compact(['trainings', 'id', 'admin']));
    }

    public function destroy($id, $action_type)
    {
        if ($action_type == 'accept') {
            $data = UserTraining::findOrFail($id);
            $data->status=1;
            $data->save();
        } else {
            $data = UserTraining::findOrFail($id);
            $data->delete();
        }
    }

}
