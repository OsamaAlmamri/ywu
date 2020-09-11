<?php

namespace App\Http\Controllers\Api\Trainings;


use App\Http\Controllers\Controller;
use App\Models\TrainingContents\TrainingTitle;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function __construct()
    {
    }
    public function index()
    {
        $Subject=TrainingTitle::with(['training','contents'])->orderByDesc('id')->get();
        if(!$Subject){
            return $this->ReturnErorrRespons('0000','لايوجد منشورات');
        }
        else{
            return  $this->GetDateResponse('Subjects',$Subject);
        }
    }
    public function show($id)
    {
        $Subject = TrainingTitle::with(['training','contents'])->whereId($id)->first();
        if (!$Subject) {
            return $this->ReturnErorrRespons('0000','لايوجد مادة بهذا الاسم');
        }
        else{
            return  $this->GetDateResponse('Subject',$Subject);
        }
    }

    public function store(Request $request)
    {
        try {
//            $rules=$this->Post_Rules();
//            $messages=$this->Post_Messages();
//            $validator = Validator::make($request->all(), $rules,$messages);
//            if ($validator->fails()) {
//                $code = $this->returnCodeAccordingToInput($validator);
//                return $this->returnValidationError($code, $validator);
//            }
            $Subject = new TrainingTitle();
            $Subject->name=$request->name;
            $Subject->training_id = $request->training_id;
            $Subject->save();
            if ($Subject->save())
                return $this->GetDateResponse('Subject',$Subject,"تم نشر");
        }catch (\Exception $ex){
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
//        $rules=$this->Post_Rules();
//        $messages=$this->Post_Messages();
//        $validator = Validator::make($request->all(), $rules,$messages);
//        if ($validator->fails()) {
//            $code = $this->returnCodeAccordingToInput($validator);
//            return $this->returnValidationError($code, $validator);
//        }

        $Subject=TrainingTitle::whereId($id)->first();
        if($Subject){
            $Subject->name=$request->name;
            $Subject->training_id = $request->training_id;
            $Subject->update();
            if ($Subject) {
                return $this->GetDateResponse('Subject',$Subject,"تم التعديل");
            } else {
                return $this->ReturnErorrRespons('0000','حدث خطاء غير متوقع');
            }
        }
    }

    public function destroy($id)
    {
        $Subject=TrainingTitle::whereId($id)->first();
        if ($Subject->delete()) {
            return $this->ReturnSuccessRespons("200","تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لحذف هذا المنشور');
        }
    }
}
