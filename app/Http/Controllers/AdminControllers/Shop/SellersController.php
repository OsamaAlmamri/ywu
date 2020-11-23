<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Branch;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Job;
use App\Models\Shop\ShopCategory;
use App\Seller;
use App\Traits\PostTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SellersController extends Controller
{
    use PostTrait;

    public function __construct()
    {
        $this->middleware('permission:show sellers', ['only' => ['index', 'show']]);
        $this->middleware('permission:manage sellers', ['only' => ['changeOrder', 'destroy', 'edit', 'store', 'update', 'active']]);
        $this->middleware('permission:active sellers', ['only' => ['active']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $post = Admin::with('seller')->where('type', 'seller')->get();
            if ($post) {
                return datatables()->of($post)
                    ->addColumn('action', function ($row) {
                        return view('admin.shop.sellers.btn.action')->with('id', $row->id)
                            ->with('images', $row->seller->images);
                    })
//                    ->addColumn('action', 'admin.shop.sellers.btn.action')
                    ->addColumn('btn_status', 'admin.shop.sellers.btn.status')
                    ->rawColumns(['action', 'btn_status'])
                    ->make(true);
            }
        }
        return view('admin.shop.sellers.index');
    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = Admin::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }


    public
    function destroy($id)
    {
        $data = Admin::findOrFail($id);
        $data->status = 1;
        $data->update();
        if ($data) {
            $data->delete();
        }
    }

    public function showImages($id)
    {
        $data = Seller::where('admin_id', $id)->get()->first();

        $images = explode(',',json_decode( $data->images));
//        $images = explode(',', $data->images);

        $images_view = view('admin.shop.sellers.images')->with('images', $images);
        return response()->json($images_view->render());

    }
}
