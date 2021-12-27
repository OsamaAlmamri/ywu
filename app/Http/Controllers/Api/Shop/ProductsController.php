<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use App\Models\Rateable\Rating;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\QuestionReplay;
use App\Models\Shop\ShopCategory;
use App\Models\TrainingContents\Training;
use App\Seller;
use App\Traits\JsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    use JsonTrait;


    function product_rate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'product_id' => 'required|numeric',
                    'rating' => 'required|numeric|min:1|max:5',
                    'message' => 'required',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            $product = Product::find($request->product_id);
            $rateable_type = 'App\Models\Shop\Product';
            $oldRating = Rating::all()
                ->where('rateable_id', $request->product_id)
                ->where('user_id', auth()->id())
                ->where('rateable_type', $rateable_type)->first();
            if ($oldRating != null) {
                $oldRating->update([
                    'rating' => $request->rating,
                    'message' => $request->message,
                ]);
                return $this->GetDateResponse("data", $oldRating, 'تم تعديل التقييم بنجاح');
            } else {
                $rating = new Rating();
                $rating->rating = $request->rating;
                $rating->message = $request->message;
//                $rating->rateable_id = $request->course_id;
                $rating->user_id = auth()->id();
                $product->ratings()->save($rating);
                $oldRating = Rating::find($rating->id);

                return $this->GetDateResponse("data", $oldRating, "تم التقييم بنجاح  ");
            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }


    }

    function ratingInfo($course_id)
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        $training = Product::with(['is_rating', 'ratings' => function ($q) use ($user_id) {
            $q->where('user_id', '!=', $user_id);
        }])->where('id', $course_id)->get()->first();
        return $training;
    }

    function rate2(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'product_id' => 'required|numeric',
                    'rating' => 'required|numeric|min:1|max:5',
                    'message' => 'required',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            $training = Product::find($request->product_id);
            $rateable_type = Product::class;
            $oldRating = Rating::all()
                ->where('rateable_id', $request->product_id)
                ->where('user_id', auth()->id())
                ->where('rateable_type', $rateable_type)->first();
            if ($oldRating != null) {
                $oldRating->update([
                    'rating' => $request->rating,
                    'message' => $request->message,
                ]);
                return $this->GetDateResponse("data", $this->ratingInfo($request->product_id), 'تم تعديل التقييم بنجاح');
            } else {
                $rating = new Rating();
                $rating->rating = $request->rating;
                $rating->message = $request->message;
                $rating->user_id = auth()->id();
                $training->ratings()->save($rating);
                $Training = $this->ratingInfo($request->product_id);
                return $this->GetDateResponse("data", $Training, "تم التقييم بنجاح  ");
            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }


    }

    public function addQuestion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
                'text' => 'required',
            ],
                [
                    'product_id.required' => 'رقم المنتج مطلوب',
                    'text.required' => ' نص السؤال مطلوب',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            $q = ProductQuestion::create(array_merge($request->all(), [
                'customers_id' => auth()->user()->id,
            ]));
            return $this->GetDateResponse("data", $q, 'تم اضافة السؤال بنجاح');


        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());


        }
    }

    public function updateQuestion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_question_id' => 'required',
                'text' => 'required',
            ],
                [
                    'product_question_id.required' => 'رقم السؤال مطلوب',
                    'text.required' => ' نص السؤال مطلوب',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            if (auth()->user() != null) {
                $q = ProductQuestion::find($request->product_question_id);
                if ($q != null and $q->customers_id == auth()->user()->id)
                    $q->update($request->all());
                return $this->GetDateResponse("data", $q, 'تم تعديل السؤال بنجاح');

            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }
    }

    public function deleteQuestion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_question_id' => 'required',
            ],
                [
                    'product_question_id.required' => 'رقم السؤال مطلوب',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            if (auth()->user() != null) {
                $q = ProductQuestion::find($request->product_question_id);
                if ($q != null and $q->customers_id == auth()->user()->id) {
                    $reples = QuestionReplay::all()->where('product_question_id', $request->product_question_id)
                        ->where('replay_user_type', 'admin')->count();
                    if ($reples == 0) {
                        $q->delete();
                        return $this->GetDateResponse("data", 1, 'تم الحذف بنجاح');

                    }
                }
                return $this->ReturnErorrRespons("0000", 'لايمكن حذف هذا السؤال');

            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }
    }

    public function addReplay(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_question_id' => 'required',
                'text' => 'required',
            ],
                [
                    'product_question_id.required' => 'رقم السؤال مطلوب',
                    'text.required' => ' نص الرد مطلوب',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            if (auth()->user() != null) {
                $r = QuestionReplay::create(array_merge($request->all(), [
                    'replay_user_id' => auth()->user()->id,
                    'replay_user_type' => 'customer',
                ]));
                $reply = QuestionReplay::find($r->id);

                return $this->GetDateResponse("data", $r, 'تم اضافة الرد  بنجاح');
            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }
    }


    public function updateReplay(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'replay_id' => 'required',
                'text' => 'required',
            ], [
                'replay_id.required' => 'رقم الرد مطلوب',
                'text.required' => ' نص الرد مطلوب',
            ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            if (auth()->user() != null) {
                $q = QuestionReplay::find($request->replay_id);
                if ($q != null and $q->replay_user_id == auth()->user()->id)
                    $q->update($request->all());
                return $this->GetDateResponse("data", $q, 'تم تعديل الرد بنجاح');
            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }
    }


    public function deleteReplay(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'replay_id' => 'required',
            ], [
                'replay_id.required' => 'رقم الرد مطلوب',
            ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            if (auth()->user() != null) {
                $q = QuestionReplay::find($request->replay_id);
                if ($q != null and $q->replay_user_id == auth()->user()->id) {
                    $q->delete();
                } else
                    return $this->GetDateResponse("data", 'لايممكن حذف هذا الرد');
                return $this->GetDateResponse("data", 1, 'تم حذف الرد بنجاح');
            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());
        }
    }


    public function product_details(Request $request)
    {
        $data = Product::with(['defaults_attributes', 'images'])
            ->where('id', $request->product_id)->first()->append(['product_options']);
        return $this->GetDateResponse('data', $data);
    }


    public function gov_seller(Request $request)
    {
        $data = Seller::with(['admin:id,name,email,phone,created_at'])
            ->where('gov_id', $request->gov_id)->get();
        return $this->GetDateResponse('data', $data);
    }


    public function get_product_by_categories(Request $request)
    {
        $has_categories = false;
        $has_govs = false;
        $has_seller = false;
        if (isset($request->seller_id) and $request->seller_id > 0)
            $has_seller = true;
        if (isset($request->govs) and count($request->govs) > 0)
            $has_govs = true;
        if (isset($request->categories) and count($request->categories) > 0)
            $has_categories = true;

        try {
            $data = ShopCategory::with(['products' => function ($q) use ($has_seller, $has_govs, $request) {
                $q->where('status', 1);
                if ($has_govs) {
                    $q->whereIn('admin_id', function ($query) use ($request) {
                        $query->select('admin_id')
                            ->from(with(new Seller())->getTable())
                            ->whereIn('gov_id', $request->govs);
                    });
                }
                if ($has_seller) {
                    $q->where('admin_id', $request->seller_id);
                }
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
            return $this->ReturnErorrRespons('0000', $ex->getMessage());
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

                ->where('category_id', $request->category_id);
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
