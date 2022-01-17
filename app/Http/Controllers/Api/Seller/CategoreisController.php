<?php

namespace App\Http\Controllers\Api\Seller;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product2;
use App\Models\Shop\Seller2;
use App\Seller;
use App\Traits\JsonTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoreisController extends Controller
{
    use JsonTrait;

    public function __construct()
    {
        //  Config::set('auth.defaults.guard', "admin");
    }


    public function get_products(Request $request)
    {
        try {
            $data = Product2::where('products.admin_id', auth()->id())
                ->leftJoin('shop_categories', 'shop_categories.id', '=', 'products.category_id')
                ->select(['products.*',
                    DB::raw("(SELECT ROUND(COALESCE(AVG(rating),0),0) FROM ratings WHERE rateable_id=products.id) as average_rating"),
                    DB::raw("(SELECT ROUND(COALESCE(AVG(rating),0),0)  FROM ratings WHERE rateable_id=products.id) as average_rating1"),
                    DB::raw("(SELECT count(rating) FROM ratings WHERE rateable_id=products.id) as count_rating"),
                    DB::raw("(SELECT count(rating) FROM ratings WHERE rateable_id=products.id) as count_rating1"),
                    DB::raw("DATE_FORMAT( products.created_at,'" . getDBCustomDate() . "') AS published"),

                    'shop_categories.name as category'])
                ->where('products.status', 1);
            if (isset($request->category_id) and $request->category_id != "all")
                $data = $data->where('products.category_id', $request->category_id);
            $data = $data->paginate(15);
            if (!$data) {
                return $this->ReturnErorrRespons('0000', 'لايوجد اصناف');
            } else {
                return $this->GetDateResponse('data', $data);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


    public function get_seller_info($id)
    {
        try {


            $data = Seller2::whereIn('sellers.admin_id', function ($query)  {
                $query->select('id')
                    ->from(with(new Admin())->getTable())
                    ->where('deleted_at', null)
                    ->where('status', '=', 1);
            })->leftJoin('zones as govs', 'sellers.gov_id', '=', 'govs.id')
                ->leftJoin('zones as dis', 'sellers.district_id', '=', 'dis.id')
                ->select(['sellers.*', 'dis.name_ar as district', 'govs.name_ar as gov', 'dis.name_en as district_en', 'govs.name_en as gov_en'])
                ->where('admin_id', $id)->get()->first();;

            if (!$data) {
                return $this->ReturnErorrRespons('0000', 'لايوجد ');
            } else {
                return $this->GetDateResponse('data', $data);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


}
