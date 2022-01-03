<?php

namespace App\Http\Controllers\Api\Seller;

use App\Admin;
use App\Http\Controllers\AdminControllers\Shop\MediaController;
use App\Http\Controllers\Controller;
use App\Models\Images;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\Product;
use App\Models\Shop\ProductImage;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ProductImagesController extends Controller
{
    use JsonTrait;


    private function check_inputes($request, $action = 'store')
    {
        $rules = [
            "product_id" => [($action == 'Edit') ? 'nullable' : 'required'],
            "id" => [($action != 'Edit') ? 'nullable' : 'required'],

            "file" => ['image', 'required'],
        ];
        $messages = [
            "file.required" => "يرجى اختيار صورة اولا ",
            "file.images" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",

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
        $product_image = ProductImage::create(['product_id' => $request->product_id, 'image_id' => $im]);
        return $this->GetDateResponse('data', $product_image, 'تم الاضافة  بنجاح');

    }


    public function update(Request $request)
    {
        $validator = $this->check_inputes($request);


        $validator = $this->check_inputes($request, 'Edit');
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $product_image = ProductImage::find($request->id);

        $image = new Images();
        $media = new MediaController($image);
        $im = $media->fileUpload($request, 0);
        $product_image = $product_image->update(array_merge($request->except('image_id'),
            [
                'image_id' => $im
            ]));
        $product_image = ProductImage::find($request->id);
        // return response()->json(['success' => 'تم التعديل  بنجاح']);
        return $this->GetDateResponse('data', $product_image, 'تم التعديل  بنجاح');

    }

    public function destroy(Request $request)
    {
        $image = ProductImage::find($request->id);

        if ($image == null)
            return $this->ReturnErorrRespons('0000', ' الصورة غير موجود');

        $data = Product::find($image->product_id);
        if ($data->admin_id != auth()->id())
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا الصورة');

        $image->delete();
        return $this->ReturnSuccessRespons("200", "تم الحذف بنجاح");


    }

}
