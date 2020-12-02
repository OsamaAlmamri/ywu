<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\ContactU;
use App\Http\Controllers\Controller;
use App\Models\Shop\ShopCategory;


class ContactController extends Controller

{
    public function index()
    {

        if (request()->ajax()) {
            $data = ContactU::all();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.contacts.btn.action')
                    ->make(true);
            }
        }
        return view('admin.shop.contacts.index');
    }
    public function destroy($id)
    {
        $data = ContactU::findOrFail($id);
        $data->delete();
    }


}
