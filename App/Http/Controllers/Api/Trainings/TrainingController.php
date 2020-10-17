<?php

namespace App\Http\Controllers\Api\Trainings;

use App\Http\Controllers\Controller;
use App\Http\Resources\LastPosts;
use App\Like;
use App\Models\Rateable\Rating;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\TitleContent;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
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
            $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
            $Training = Training::with(['ratings' => function ($q) use ($user_id) {
                $q->where('user_id', '!=', $user_id);
            }, 'is_rating', 'result', 'is_register', 'titles' => function ($q) {
                $q->with(['contents']);
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
                $q->with(['contents']);
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

    public function getLastPosts(Request $request)
    {
        try {
            $type = $request->type;
            if ($type == 'trainings')
//                $data = Training::orderByDesc('id')->limit(5)->get();
                $data = LastPosts::collection(Training::orderByDesc('id')->limit(5)->get())->type('trainings');

            if ($type == 'posts')
//                $data = Training::orderByDesc('id')->limit(5)->get();
                $data = LastPosts::collection(Post::with('category')->orderByDesc('id')->limit(5)->get())->type('posts');

            else {
                $data = LastPosts::collection(WomenPosts::orderByDesc('id')->limit(5)->get())->type('women');

            }
            if (!$data) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('data', $data);
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

    public function complete_content(Request $request)
    {
        try {

            $user_content = UserTrainingTiltle::where('content_id', $request->id)
                ->get()->count();
            $content = TitleContent::find($request->id);

            if ($user_content == 0 and $content != null) {
                UserTrainingTiltle::create(
                    ['user_id' => auth()->id(),
                        'content_id' => $request->id,
                        'title_id' => $content->title_C->id,
                    ]);

            }
//            return $this->GetDateResponse('data',  $request->id);

            $completeTitile = 0;
            if ($content != null) {
//                return $this->GetDateResponse('data',  $content->title_C);
                $countTiltiles = $content->title_C->contents->count();
                $progress = $content->title_C->user_contents->count();
                $user_title = UserTrainingTiltle::where('title_id', $content->title_C->id)
                    ->where('content_id', 0)->get();
                if ($progress >= $countTiltiles) {
                    $completeTitile = 1;
                    if ($user_title == null)
                        UserTrainingTiltle::create(
                            ['user_id' => auth()->id(),
                                'content_id' => 0,
                                'title_id' => $content->title_C->id,
                            ]);
                } else {
                    if ($user_title) {
//                        $user_title->delete();
                        $completeTitile = 0;
//                        $user_title->save();
                    }
                }
            }

            return $this->GetDateResponse('title_complete', $completeTitile, 'تم تحديد المحتوى كمكتمل ' . $request->id);
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

    public function has_progress($trining_id)
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return UserTrainingTiltle::whereIn('title_id', function ($query) use ($trining_id) {
            $query->select('id')
                ->from(with(new TrainingTitle())->getTable())
                ->where('training_id', $trining_id);
        })->where('user_id', $user_id)->count();
    }

    public function register_to_training(Request $request)
    {
        try {
            $likes = UserTraining::where('user_id', auth()->id())
                ->where('training_id', $request->training_id)
//                ->where('status', 0)
                ->get()->first();
            $t = Training::find($request->training_id);
            $user_training = $this->has_progress($request->training_id);
            if (!$likes) {
                $l = new UserTraining();
                $l->user_id = auth()->id();
                $l->status = $t->type == 'عام';
                $l->training_id = $request->training_id;
                $l->save();
                $m = ($t->type == 'عام') ? " " : " و بانتظار الموافقة عليك";
                return $this->GetDateResponse('data', $l, "تم التسجيل بالدورة" . $m);
            } else if ($user_training > 0) {
                return $this->GetDateResponse('data', $likes, 'لا يمكن اللغاء التسجيل بعد البدء بالتدريب ');
            }
//            else if ($likes->status == 1 and  ) {
//                return $this->GetDateResponse('data', $likes, 'لا يمكن اللغاء التسجيل بعد الموافة على التسجيل');
//            }
            else {
                $likes->delete();
                return $this->GetDateResponse('data', null, "تم الغاء التسجيل بالدورة ");
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
            } elseif ($request->type == 'trainings') {
                $likes = Training::with(['is_register'])
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
        } catch
        (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->search;
            if ($request->type == 'posts') {
                $data = Post::with(['category'])
                    ->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('body', 'LIKE', '%' . $search . '%')
                    ->get();
            } elseif ($request->type == 'trainings') {
                $data = Training::with(['subject', 'is_register'])
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('learn', 'LIKE', '%' . $search . '%')
                    ->orWhere('instructor', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->get();

            } else {
                $type = 'women_posts';
                $data = WomenPosts::where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('body', 'LIKE', '%' . $search . '%')
                    ->get();
            }
            return $this->GetDateResponse('data', $data);
        } catch
        (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
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
                $training->ratings()->save($rating);
                $oldRating = Rating::find($rating->id);
                return $this->GetDateResponse("data", $oldRating, "تم التقييم بنجاح  ");
            }
        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }


    }

    function delete_rate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'id' => 'required|numeric',

                ]);
            if ($validator->fails()) {
                return $this->ReturnErorrRespons('0000', $validator->errors());
            }
            $oldRating = Rating::where('id', $request->id)
                ->where('user_id', \auth()->id());
            $is_deleted = 0;
            if ($oldRating != null) {
                $is_deleted=  $oldRating->delete();
            }
            return $this->GetDateResponse("data", $is_deleted, 'تم حذف التقييم بنجاح');

        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }


    }
}
