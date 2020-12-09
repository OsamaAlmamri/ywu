<?php

namespace App\Http\Controllers\Api\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ShopCategory;
use App\Seller;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;

class CategoreisController extends Controller
{
    use JsonTrait;

    public
    function all_categories(Request $request)
    {
        $data = ShopCategory::where('status', 1)->orderBy('sort')->get();
        return $this->GetDateResponse('data', $data);
    }

    public function seller_name(Request $request)
    {
        $data = Seller::where('admin_id', $request->id)->get()->first();
        if ($data != null) {

            return $this->GetDateResponse('data', $data);
        }
        return $this->ReturnErorrRespons("0000", "لايوجد متجر بهذ الرقم");

    }

    public function product_details(Request $request)
    {
        $data = Product::with(['ratings', 'defaults_attributes',
            'images', 'product_questions' => function ($q) {
                $q->with('replies');
            }])
            ->where('id', $request->product_id)
            ->first()->append(['product_options']);
        return $this->GetDateResponse('data', $data);
    }


    public function gov_seller(Request $request)
    {
        if (isset($request->gov_id) and $request->gov_id > 0)
            $data = Seller::with(['admin:id,name,email,phone,created_at'])
                ->whereIn('admin_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from(with(new Admin())->getTable())
                        ->where('status', 1)
                        ->where('deleted_at', null);
                })
                ->where('gov_id', $request->gov_id)->get();
        else
            $data = Seller::with(['admin:id,name,email,phone,created_at'])
                ->whereIn('admin_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from(with(new Admin())->getTable())
                        ->where('status', 1)
                        ->where('deleted_at', null);
                })->get();
        return $this->GetDateResponse('data', $data);
    }


    public function gov_sellers(Request $request)
    {
        if (count($request->govs) > 0) {
            $data = Seller::whereIn('gov_id', $request->govs)
                ->whereIn('admin_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from(with(new Admin())->getTable())
                        ->where('deleted_at', null)
                        ->where('status', '=', 1);
                })->get();
        } else
            $data = Seller::whereIn('admin_id', function ($query) use ($request) {
                $query->select('id')
                    ->from(with(new Admin())->getTable())
                    ->where('deleted_at', null)
                    ->where('status', '=', 1);
            })->get();

        return $this->GetDateResponse('data', $data);
    }


    public function get_product_by_categories22(Request $request)
    {
        $has_categories = false;
        $has_govs = false;
        $has_seller = false;
        if (isset($request->seller_id) and count($request->seller_id) > 0)
            $has_seller = true;
        if (isset($request->govs) and count($request->govs) > 0)
            $has_govs = true;
        if (isset($request->categories) and count($request->categories) > 0)
            $has_categories = true;

        try {
            $data = ShopCategory::with(['products' => function ($q) use ($has_seller, $has_govs, $request) {
                $q->inRandomOrder()->where('status', 1);
                if ($has_govs) {
                    $q->whereIn('admin_id', function ($query) use ($request) {
                        $query->select('admin_id')
                            ->from(with(new Seller())->getTable())
                            ->whereIn('gov_id', $request->govs);
                    });
                }
                if ($has_seller) {
                    $q->whereIn('admin_id', $request->seller_id);
                }
                $q->limit(30)->get();

            }]);
            if ($has_categories) {
                $data = $data->whereIn('id', $request->categories);
            }

            $data = $data
                ->whereExists(function ($query) use ($has_seller, $request) {

                    $query->select("products.id")
                        ->from('products')
                        ->whereRaw('products.category_id = shop_categories.id');
                    if ($has_seller) {
                        $query->where('products.admin_id', $request->seller_id);
                    }
                })
                ->orderBy('sort')->get();
            if (!$data) {
                return $this->ReturnErorrRespons('0000', 'لايوجد اصناف');
            } else {
                return $this->GetDateResponse('data', $data);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function get_product_by_categories(Request $request)
    {
        $has_categories = false;
        $has_govs = false;
        $has_seller = false;
        if (isset($request->seller_id) and $request->seller_id > 0)
            $has_seller = true;
        if (isset($request->govs) and ($request->govs) > 0)
            $has_govs = true;
        if (isset($request->categories) and ($request->categories) > 0)
            $has_categories = true;

        try {
            $data = ShopCategory::with(['products' => function ($q) use ($has_seller, $has_govs, $request) {
                $q->inRandomOrder()->where('status', 1);
                if ($has_govs) {
                    $q->whereIn('admin_id', function ($query) use ($request) {
                        $query->select('admin_id')
                            ->from(with(new Seller())->getTable())
                            ->where('gov_id', $request->govs);
                    });
                }
                if ($has_seller) {
                    $q->where('admin_id', $request->seller_id);
                }
//                $q->latest()->limit(1);
            }]);
            if ($has_categories) {
                $data = $data->where('id', $request->categories);
            }

            $data = $data
                ->whereExists(function ($query) use ($has_seller, $request) {

                    $query->select("products.id")
                        ->from('products')
                        ->whereRaw('products.category_id = shop_categories.id');
                    if ($has_seller) {
                        $query->where('products.admin_id', $request->seller_id);
                    }
                })
                ->orderBy('sort')->get();
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
            $has_seller = false;
            if (isset($request->seller_id) and $request->seller_id > 0)
                $has_seller = true;
            $has_govs = false;
            if (isset($request->govs) and count($request->govs) > 0)
                $has_govs = true;
            $data = Product::where('status', 1)
                ->where('category_id', $request->category_id)
                ->whereIn('admin_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from(with(new Admin())->getTable())
                        ->where('deleted_at', null)
                        ->where('status', '=', 1);
                });
            if ($has_govs) {
                $data = $data->whereIn('admin_id', function ($query) use ($request) {
                    $query->select('admin_id')
                        ->from(with(new Seller())->getTable())
                        ->whereIn('gov_id', $request->govs);
                });;
                if ($has_seller) {
                    $data = $data->where('admin_id', $request->seller_id);
                }

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
