<?php

namespace App\Http\Controllers\Api\Trainings;

use App\Http\Controllers\Controller;
use App\Like;
use App\Models\Rateable\Rating;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\Training;
use App\Question;
use App\Result;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use App\UserTraining;
use App\UserTrainingTiltle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    protected $emp;
    protected $other;
    use JsonTrait;
    use PostTrait;


    public function index()
    {
        $this->emp = Auth::user();
        try {
            $Training = Training::with(['titles', 'is_register'])
                ->where('type', 'خاص')->orwhere('type', 'عام')
                ->orderByDesc('id')->paginate(20);
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function myTraining()
    {
        $this->emp = Auth::user();
        try {
            $Training = Training::with(['subject', 'titles', 'is_register'])
                ->whereIn('id', function ($query) {
                    $query->select('training_id')->from('user_trainings')
                        ->where('user_id', Auth::id());
                })
                ->orderByDesc('id')->paginate(20);
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function getTrainingDetails(Request $request)
    {
        try {
            $Training = Training::with(['ratings', 'result', 'is_register', 'titles' => function ($q) {
                $q->with(['contents', 'is_complete:title_id,created_at']);
            }])
                ->where('id', $request->id)->get()->first();
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function index2(Request $request)
    {
        try {
            $Training = Training::with(['result', 'category', 'is_register', 'titles' => function ($q) {
                $q->with(['contents', 'is_complete:title_id,created_at']);
            }])
                ->where('id', $request->id)->get()->first();
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function getTrainingQuestions(Request $request)
    {
        try {
            $Training = Question::orderByRaw("RAND()")->where('training_id', $request->id)->get();
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function showTrainingByCategory()
    {
        try {
            $Training = SubjectCategory::with(['trainings' => function ($sub) {
                $sub->with(['is_register', 'departments']);
            }])->get();
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function showTrainingByCategory2()
    {
        try {
            $Training = SubjectCategory::with(['trainings' => function ($sub) {
                $sub->with(['is_register', 'departments']);
            }])->get();
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function index_others()
    {
        $this->other = Auth::guard('shared-user-api')->user();
        try {
            $Training = Training::with(['is_register', 'subject', 'titles'])->where('type', 'عام')->orderByDesc('id')->paginate(20);
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }


    public function show($id)
    {
        $Training = Training::with(['subject', 'is_register', 'titles'])->whereId($id)->first();
        if (!$Training) {
            return $this->ReturnErorrRespons('0000', 'لايوجد مادة بهذا الاسم');
        } else {
            return $this->GetDateResponse('Training', $Training);
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
            $Training->name = $request->name;
            $Training->subject_id = $request->subject_id;
            $Training->length = $request->length;
            $Training->start_at = $request->start_at;
            $Training->end_at = $request->end_at;
            $Training->thumbnail = $request->thumbnail;

            $Training->save();
            if ($Training->save())
                return $this->GetDateResponse('Training', $Training, "تم نشر");
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function complete_title(Request $request)
    {
        try {
            UserTrainingTiltle::create(['user_id' => auth()->id(), 'title_id' => $request->title_id]);
            return $this->GetDateResponse('data', "تم الحفظ");
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function set_result(Request $request)
    {
        try {
            Result::create(['user_id' => auth()->id(), 'grade' => $request->grade, 'training_id' => $request->training_id]);
            return $this->GetDateResponse('data', "تم الحفظ");
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function like(Request $request)
    {
        try {
            if ($request->type == 'posts')
                $type = 'posts';
            elseif ($request->type == 'training')
                $type = 'training';
            else
                $type = 'women_posts';
            $likes = Like::where('user_id', auth()->id())->where('liked_id', $request->liked_id)->where('type', $type)->get()->first();
            if (!$likes) {
                $l = new Like();
                $l->user_id = auth()->id();
                $l->liked_id = $request->liked_id;
                $l->type = $type;
                $l->save();
//                Like::create(['user_id' => auth()->id(), 'liked_id' => $request->liked_id, 'type' => $type]);
                return $this->GetDateResponse('data', "1");
            } else {
                $likes->delete();
                return $this->GetDateResponse('data', "0");
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function register_to_training(Request $request)
    {
        try {

            $likes = UserTraining::where('user_id', auth()->id())
                ->where('training_id', $request->training_id)
                ->get()->first();
            if (!$likes) {
                $l = new UserTraining();
                $l->user_id = auth()->id();
                $l->training_id = $request->training_id;
                $l->save();
                return $this->GetDateResponse('data', "1");
            } else {
                $likes->delete();
                return $this->GetDateResponse('data', "0");
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function my_likes(Request $request)
    {
        try {

            if ($request->type == 'posts') {
                $likes = Like::with(['post' => function ($q) {
                    $q->with(['category', 'comments']);
                }
                ])->where('user_id', auth()->id())->where('type', 'posts')->get();
            }
                elseif  ($request->type == 'trainings') {
                    $likes =   Training::with(['ratings', 'result', 'is_register', 'titles' => function ($q) {
                        $q->with(['contents', 'is_complete:title_id,created_at']);
                    }])
                        ->whereIn('id', function ($query) {
                            $query->select('liked_id')->from('likes')
                                ->where('type', 'training')
                                ->where('user_id', Auth::id());
                        })
                        ->orderByDesc('id')->get();
                } else {
                    $type = 'women_posts';
                    $likes = Like::with(['women_post'])->where('user_id', auth()->id())
                        ->where('type', 'women_posts')->get();
                }
                return $this->GetDateResponse('data', $likes);
            }
        catch
            (\Exception $ex) {
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

        $Training = Training::whereId($id)->first();
        if ($Training) {
            $Training = new Training();
            $Training->name = $request->name;
            $Training->subject_id = $request->subject_id;
            $Training->length = $request->length;
            $Training->start_at = $request->start_at;
            $Training->end_at = $request->end_at;
            $Training->thumbnail = $request->thumbnail;
            $Training->update();
            if ($Training) {
                return $this->GetDateResponse('Training', $Training, "تم التعديل");
            } else {
                return $this->ReturnErorrRespons('0000', 'حدث خطاء غير متوقع');
            }
        }
    }

    public function destroy($id)
    {
        $Training = Training::whereId($id)->first();
        if ($Training->delete()) {
            return $this->ReturnSuccessRespons("200", "تم الحذف بنجاح");
        } else {
            return $this->ReturnErorrRespons('0000', 'لاتمتلك الصلاحية لحذف هذا المنشور');
        }
    }

    function rate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'course_id' => 'required|numeric',
                    'rating' => 'required|numeric|min:1|max:5',
                    'message' => 'required',
                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }


            $training = Training::find($request->course_id);
            $rateable_type = 'App\Models\TrainingContents\Training';
            $oldRating = Rating::all()
                ->where('rateable_id', $request->course_id)
                ->where('user_id', auth()->id())
                ->where('rateable_type', $rateable_type)->count();
            if ($oldRating > 0) {
                return $this->ReturnErorrRespons('0000', 'لايمكن التقييم لاكثر من مرة');
            } else {
                $rating = new Rating();
                $rating->rating = $request->rating;
                $rating->message = $request->message;
//                $rating->rateable_id = $request->course_id;
                $rating->user_id = auth()->id();
                $training->ratings()->save($rating);
                return $this->ReturnSuccessRespons("200", "تم التقييم بنجاح  ");
            }

        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }


    }
}
