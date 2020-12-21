<?php

namespace App\Http\Controllers\Api\Trainings;

use App\ContactU;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FireBaseController;
use App\Http\Resources\LastPosts;
use App\Like;
use App\Models\Rateable\Rating;
use App\Models\Shop\Product;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\TitleContent;
use App\Models\TrainingContents\Training;
use App\Models\TrainingContents\TrainingTitle;
use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use App\Notifications\AppNotification;
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

    public function __construct(FireBaseController $firbaseContoller)
    {
        $this->firbaseContoller = $firbaseContoller;
    }

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

    public function myTraining(Request $request)
    {
        $this->emp = Auth::user();
        try {
            $Training = Training::with(['subject', 'titles', 'is_register']);
            if (isset($request->type) and $request->type == 'complete')
                $Training = $Training->whereIn('id', function ($query) {
                    $query->select('training_id')->from('user_trainings')
                        ->where('user_id', Auth::id());
                })->whereIn('id', function ($query) {
                    $query->select('training_id')->from('results')
                        ->where('user_id', Auth::id());
                });
            elseif (isset($request->type) and $request->type == 'in_progress')
                $Training = $Training->whereIn('id', function ($query) {
                    $query->select('training_id')->from('user_trainings')
                        ->where('user_id', Auth::id());
                })->whereNotIn('id', function ($query) {
                    $query->select('training_id')->from('results')
                        ->where('user_id', Auth::id());
                });
            else
                $Training = $Training->whereIn('id', function ($query) {
                    $query->select('training_id')->from('user_trainings')
                        ->where('user_id', Auth::id());
                });
            $Training = $Training->orderByDesc('id')->paginate(20);
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
                ->where('id', $request->id)->get()->first()->append('user_complete');
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
            $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;

            if ($type == 'trainings')
//                $data = Training::orderByDesc('id')->limit(5)->get();
                $data = LastPosts::collection(Training::orderByDesc('id')->limit(5)->get())->type('trainings');

            if ($type == 'posts')
//                $data = Training::orderByDesc('id')->limit(5)->get();
                $data = LastPosts::collection(Post::with('category')
                    ->where('user_id', '!=', $user_id)->where('status', 1)->orderByDesc('id')->limit(5)->get())->type('posts');

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
                ->where('user_id', auth()->id())
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
                    ->where('user_id', auth()->id())
                    ->where('content_id', 0)->get()->first();
                if ($progress >= $countTiltiles) {
                    $completeTitile = 1;
                    if ($user_title == null) {
                        UserTrainingTiltle::create(
                            ['user_id' => auth()->id(),
                                'content_id' => 0,
                                'title_id' => $content->title_C->id,
                            ]);

                    }
                } else {
                    if ($user_title) {
                        $user_title->delete();
                        $user_title->save();
                        $completeTitile = 0;
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
            $r = Result::create(['user_id' => auth()->id(), 'grade' => $request->grade, 'training_id' => $request->training_id]);
            return $this->GetDateResponse('data', $r, "تم حفظ نتيجتك بنجاح ");
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public function like(Request $request)
    {
        try {
            if ($request->type == 'product')
                $type = 'product';
            elseif ($request->type == 'posts')
                $type = 'posts';
            elseif ($request->type == 'training' or $request->type == 'trainings')
                $type = 'training';
            else
                $type = 'women_posts';
            $likes = Like::where('user_id', auth()->id())
                ->where('liked_id', $request->liked_id)->where('type', $type)->get()->first();
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
                $message = 'قام  ' . \auth()->user()->name . '  بالتسجيل ب المادة التدريبية  ' . $t->name;
                $dataToNotification = array(
                    'sender_name' => auth()->user()->name,
                    'order_id' => $t->id,
                    'notification_type' => "new_training_user",
                    'user_id' => \auth()->id(),
                    'sender_image' => url('site/images/Logo250px.png'),
                    'message' => $message,
                    'date' => $l->created_at
                );
                $admins_id = [];
                $admins = getAdminsOrderNotifucation('new_seller');
                foreach ($admins as $admin) {
                    $admins_id[] = $admin->id;
                    $admin->notify(new AppNotification($dataToNotification));
                }
                $tokens = getNotifiableUsers(0, $admins_id);
                $this->firbaseContoller->multi($tokens, $dataToNotification);

                return $this->GetDateResponse('data', $l, "تم التسجيل بالدورة" . $m);
            } else if ($user_training > 0) {
                return $this->GetDateResponse('data', $likes, 'لا يمكن الغاء التسجيل بعد البدء بالتدريب ');
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
            if ($request->type == 'product') {
                $likes = Product::whereIn('id', function ($query) {
                    $query->select('liked_id')->from('likes')
                        ->where('type', 'product')
                        ->where('user_id', Auth::id());
                })->orderByDesc('id')->get();
            } elseif ($request->type == 'posts') {
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

    public
    function my_likes_page(Request $request)
    {
        try {

            if ($request->type == 'posts') {
                $likes = Like::with(['post' => function ($q) {
                    $q->with(['category', 'comments'])->paginate(5);
                }
                ])->where('user_id', auth()->id())->where('type', 'posts')->get();
            } elseif ($request->type == 'trainings') {
                $likes = Training::with(['is_register'])
                    ->whereIn('id', function ($query) {
                        $query->select('liked_id')->from('likes')
                            ->where('type', 'training')
                            ->where('user_id', Auth::id());
                    })
                    ->orderByDesc('id')->paginate(5);
            } else {
                $type = 'women_posts';
                $likes = Like::with(['women_post'])->where('user_id', auth()->id())
                    ->where('type', 'women_posts')->paginate(5);
            }
            return $this->GetDateResponse('data', $likes);
        } catch
        (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

    public
    function search(Request $request)
    {
        try {
            $search = $request->search;
            if ($request->type == 'posts') {
                $data = Post::with(['user', 'category', 'comments', 'user_like'])
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
                $data = WomenPosts::with(['user_like'])->where('title', 'LIKE', '%' . $search . '%')
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

    function rate2(Request $request)
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
                return $this->GetDateResponse("data", $this->ratingInfo($request->course_id), 'تم تعديل التقييم بنجاح');
            } else {
                $rating = new Rating();
                $rating->rating = $request->rating;
                $rating->message = $request->message;
                $rating->user_id = auth()->id();
                $training->ratings()->save($rating);
                $Training = $this->ratingInfo($request->course_id);
                return $this->GetDateResponse("data", $Training, "تم التقييم بنجاح  ");
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
                ->where('user_id', auth()->id());
            $is_deleted = 0;
            if ($oldRating != null) {
                $is_deleted = $oldRating->delete();
            }
            return $this->GetDateResponse("data", $is_deleted, 'تم حذف التقييم بنجاح');

        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }
    }

    function delete_rate2(Request $request)
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
                ->where('user_id', auth()->id());
            $course_id = 0;
            if ($oldRating != null) {
                $course_id = $oldRating->rateable_id;
                $oldRating->delete();
            }
            $Training = $this->ratingInfo($course_id);
            return $this->GetDateResponse("data", $Training, 'تم حذف التقييم بنجاح');

        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }
    }

    function ratingInfo($course_id)
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        $training = Training::with(['is_rating', 'ratings' => function ($q) use ($user_id) {
            $q->where('user_id', '!=', $user_id);
        }])->where('id', $course_id)->get()->first();
        return $training;
    }


    function concatUs(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    //   'name',  'email', 'phone', 'message','gov'
                    'name' => 'required',
                    "phone" => "required|numeric|digits:9|starts_with:77,73,70,71",
                    "email" => "nullable|email",
                    'message' => 'required',
                ],
                [
                    "name.required" => "يرجى  كتابة اسمك",
                    "phone.required" => "يرجى كتابة رقم الهاتف",
                    "phone.numeric" => "رقم الهاتف يجب ان يكون ارقام فقط ",
                    "phone.digits" => "يجب ان يكون رقم الهاتف 9 ارقام",
                    "phone.starts_with" => "قم بكتابة رقم هاتفك الشخصي ",
                    "message.required" => "يرجى كتابة نص الرسالة ",
                ]);
            if ($validator->fails()) {
//                return $this->ReturnErorrRespons('0000', $validator->errors());
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $training = ContactU::create($request->all());
            return $this->GetDateResponse("data", 1, "تم الارسال  بنجاح  ");

        } catch (Exception $ex) {
            return $this->ReturnErorrRespons('0000', $ex->getMessage());

        }


    }

}
