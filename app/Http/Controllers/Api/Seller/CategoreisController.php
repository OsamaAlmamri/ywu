<?php

namespace App\Http\Controllers\Api\Seller;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product2;
use App\Traits\JsonTrait;
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


}
