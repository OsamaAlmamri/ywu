<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\AdminControllers\Shop\MediaController;
use App\Http\Controllers\Controller;
use App\Models\Images;
use App\Models\Rateable\Rating;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\QuestionReplay;
use App\Models\Shop\ShopCategory;
use App\Models\TrainingContents\Training;
use App\Seller;
use App\Traits\JsonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ProductsController extends Controller
{
    use JsonTrait;


    private function check_inputes($request, $action = 'store')
    {
        $rules = [
            "name" => "required",
            "category_id" => 'required',
            "price" => 'required',
            "file" => ['image', ($action == 'Edit') ? 'nullable' : 'required'],
        ];
        $messages = [
            "name.required" => "يرجى اضافة اسم الصنف",
            "category_id.required" => "يرجى اختيار صنف المنتج ",
            "price.required" => "يرجى اضافة سعر المنتج ",
            "file.required" => "يرجى اختيار صورة اولا ",

//            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

        ];
        return Validator::make($request->all(), $rules, $messages);
    }

    public function store(Request $request)
    {

        $validator = $this->check_inputes($request);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


        $image = new Images();
        $media = new MediaController($image);
        $im = $media->fileUpload($request, 0);

        $categoty = Product::create(array_merge($request->all(),
            [
                'admin_id' => auth()->id(),
                'image_id' => $im,
            ]));
        return $this->GetDateResponse('data', $categoty, 'تم الاضافة  بنجاح');
        // return response()->json(['success' => '']);
    }


    public function update(Request $request)
    {
        $validator = $this->check_inputes($request);


        $validator = $this->check_inputes($request, 'Edit');
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $categoty = Product::whereId($request->id)->first();
        $image = new Images();
        $media = new MediaController($image);
        $im = $media->fileUpload($request, 0, $categoty->image_id);
        $categoty = $categoty->update(array_merge($request->except('image_id'),
            [
                'image_id' => $im
            ]));
        $categoty = Product::whereId($request->id)->first();
        // return response()->json(['success' => 'تم التعديل  بنجاح']);
        return $this->GetDateResponse('data', $categoty, 'تم التعديل  بنجاح');

    }

    public function destroy(Request $request)
    {
        $data = Product::find($request->id);
        if ($data == null)
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنتج');
        $c = OrderProduct::all()->where('product_id', $request->id)->count();

        if ($data->admin_id != auth()->id())
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنتج');
        if ($c == 0) {
            $data->delete();
            return $this->ReturnSuccessRespons("200", "تم الحذف بنجاح");

        } else
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنشورا يمكن حذف هذا المنتج لوجود طلبات مرتبطة بة');

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
            $q = ProductQuestion::find($request->product_question_id);
            $p = Product::where("admin_id", auth()->id())->where("id", $q->product_id)->get()->first();
            if (auth()->user() != null and $p != null) {
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
                    'replay_user_id' => auth()->id(),
                    'replay_user_type' => 'admin',
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
