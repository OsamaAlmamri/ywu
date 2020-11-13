<?php

namespace App\Http\Controllers\Api\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductsAttribute;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\Zone;
use App\Rules\MatchOldPassword;
use App\Seller;
use App\ShareUser;
use App\Traits\AuthTrait;
use App\Traits\JsonTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoreisController extends Controller
{
    use JsonTrait;

    public
    function all_categories(Request $request)
    {
        $data = ShopCategory::where('status', 1)->orderBy('sort')->get();
        return $this->GetDateResponse('data', $data);
    }

    public
    function product_details(Request $request)
    {
        $data = Product::with(['defaults_attributes','images'])

            ->where('id',$request->product_id)->first()->append(['product_options']);
        return $this->GetDateResponse('data', $data);
    }


    public function get_product_by_categories(Request $request)
    {
        $has_categories = false;
        $has_govs = false;
        if (isset($request->govs) and count($request->govs) > 0)
            $has_govs = true;
        if (isset($request->categories) and count($request->categories) > 0)
            $has_categories = true;

        try {
            $data = ShopCategory::with(['products' => function ($q) use ($has_govs, $request) {
                $q->where('status', 1);
                if ($has_govs) {
                    $q->whereIn('admin_id', function ($query) use ($request) {
                        $query->select('admin_id')
                            ->from(with(new Seller())->getTable())
                            ->whereIn('gov_id', $request->govs);
                    });;
                }
            }]);
            if ($has_categories) {
                $data = $data->whereIn('id', $request->categories);
            }
            $data = $data->orderBy('sort')->get();
            if (!$data) {
                return $this->ReturnErorrRespons('0000', 'لايوجد اصناف');
            } else {
                return $this->GetDateResponse('data', $data);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function get_category_products(Request $request)
    {
        try {
            $has_govs = false;
            if (isset($request->govs) and count($request->govs) > 0)
                $has_govs = true;
            $data = Product::where('status', 1)
                ->where('category_id', $request->category_id);
            if ($has_govs) {
                $data = $data->whereIn('admin_id', function ($query) use ($request) {
                    $query->select('admin_id')
                        ->from(with(new Seller())->getTable())
                        ->whereIn('gov_id', $request->govs);
                });;
            }
            $data = $data->orderBy('sort')->paginate(20);
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
