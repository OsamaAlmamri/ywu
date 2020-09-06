<?php

namespace App\Http\Controllers\Api\Trainings;

use App\Http\Controllers\Controller;
use App\Models\TrainingContents\Training;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    protected $emp;
    protected $other;
    use JsonTrait;
    use PostTrait;


    public function index()
    {
        $this->emp = Auth::guard('employee-api')->user();
        try{
            $Training=Training::with(['subject','titles'])->where('type','خاص')->orwhere('type','عام')->orderByDesc('id')->paginate(5);
            if(!$Training){
                return $this->ReturnErorrRespons('0000','لايوجد منشورات');
            }
            else{
                return  $this->GetDateResponse('Trainings',$Training);
            }
        }catch (\Exception $ex){
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }
    public function index_others()
    {
        $this->other = Auth::guard('shared-user-api')->user();
        try{
            $Training=Training::with(['subject','titles'])->where('type','عام')->orderByDesc('id')->paginate(5);
            if(!$Training){
                return $this->ReturnErorrRespons('0000','لايوجد منشورات');
            }
            else{
                return  $this->GetDateResponse('Trainings',$Training);
            }
        }catch (\Exception $ex){
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }
    public function show($id)
    {
        $Training = Training::with(['subject','titles'])->whereId($id)->first();
        if (!$Training) {
            return $this->ReturnErorrRespons('0000','لايوجد مادة بهذا الاسم');
        }
        else{
            return  $this->GetDateResponse('Training',$Training);
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
            $Training = new Training();
            $Training->name=$request->name;
            $Training->subject_id = $request->subject_id;
            $Training->length = $request->length;
            $Training->start_at = $request->start_at;
            $Training->end_at = $request->end_at;
            $Training->thumbnail = $request->thumbnail;

            $Training->save();
            if ($Training->save())
                return $this->GetDateResponse('Training',$Training,"تم نشر");
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

        $Training=Training::whereId($id)->first();
        if($Training){
            $Training = new Training();
            $Training->name=$request->name;
            $Training->subject_id = $request->subject_id;
            $Training->length = $request->length;
            $Training->start_at = $request->start_at;
            $Training->end_at = $request->end_at;
            $Training->thumbnail = $request->thumbnail;
            $Training->update();
            if ($Training) {
                return $this->GetDateResponse('Training',$Training,"تم التعديل");
            } else {
                return $this->ReturnErorrRespons('0000','حدث خطاء غير متوقع');
            }
        }
    }

    public function destroy($id)
    {
        $Training=Training::whereId($id)->first();
        if ($Training->delete()) {
            return $this->ReturnSuccessRespons("200","تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000','لاتمتلك الصلاحية لحذف هذا المنشور');
        }
    }
}
