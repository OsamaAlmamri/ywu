<?php

namespace App\Http\Controllers\Api\Seller;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\Product2;
use App\Models\Shop\Seller2;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\ShopCategory2;
use App\Models\Shop\Zone;
use App\Seller;
use App\Traits\JsonTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->select(['products.*',
                    DB::raw("(SELECT COALESCE(AVG(rating),0) FROM ratings WHERE rateable_id=products.id  ) as average_rating"),
                    DB::raw("(SELECT count(rating) FROM ratings WHERE rateable_id=products.id) as count_rating"),
                    DB::raw("DATE_FORMAT( products.created_at,'" . getDBCustomDate() . "') AS published"),
                    'categories.name as category'])
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


}
