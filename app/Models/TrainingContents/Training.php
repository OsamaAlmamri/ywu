<?php

namespace App\Models\TrainingContents;

use App\Category_Training;
use App\Department;
use App\EmployeeCategory;
use App\Exam;
use App\Like;
use App\Models\Rateable\Rateable;
use App\Models\Rateable\Rating;
use App\Result;
use App\SectionTraining;
use App\UserTraining;
use App\UserTrainingTiltle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;
    use  Rateable;

    protected $table = 'trainings';
    protected $guarded = [];
    protected $with = ['is_like'];


    protected $appends = ['published','thumbnail2', 'can_register',
        'is_begin_training', 'average_rating', 'count_rating', 'percent_rating', 'rating_details'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    function getPercentRatingAttribute()
    {
        return $this->ratingPercent();
    }
    function getThumbnail2Attribute()
    {
        return $this->attributes['thumbnail'];
    }
    public function averageRating()
    {
        return $this->ratings()->avg('rating');

    }
    function getAverageRatingAttribute()
    {
        return round($this->averageRating(), 1);
    }

    function getRatingDetailsAttribute()
    {
        return array(
            'one' => round($this->oneRating(), 1),
            'tow' => round($this->towRating(), 1),
            'three' => round($this->threeRating(), 1),
            'four' => round($this->fourRating(), 1),
            'five' => round($this->fiveRating(), 1),
            'sum' => $this->countRating(),
            'average' => round($this->averageRating(), 1),
        );
    }

    function getCountRatingAttribute()
    {
        return $this->countRating();
    }

    public function is_rating()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(Rating::class, 'rateable_id', 'id')
            ->where('rateable_type', Training::class)
            ->where('user_id', $user_id);
    }

    public function getCanRegisterAttribute()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        $user = auth()->guard('api')->user();
        if ($user_id == 0)
            return 0;
        elseif ($this->type == 'عام')
            return 1;
        elseif ($user->type == 'employees') {
            $department = $user->employee->department_id;
            $user = SectionTraining::where('department_id', $department)
                ->where('training_id', $this->id)->count();
            return ($user > 0) ? 1 : 0;
        } else {
            return 0;
        }
    }



    function getIsBeginTrainingAttribute()
    {
        return ($this->begin_training()->count()) > 0;
    }



    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'start_at' => 'date:Y-m-d',
        'end_at' => 'date:Y-m-d',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    function getUserCompleteAttribute()
    {
        $complete = $this->user_titile()->count();
        $titles = $this->titles()->count();
//
        return array(
            'is_complete' => $complete >= $titles,
            'complete' => $complete,
            'titles' => $titles
        );

    }

    public function category()
    {
        return $this->belongsTo(SubjectCategory::class, 'category_id', 'id');
    }

    public function titles()
    {
        return $this->hasMany(TrainingTitle::class, 'training_id', 'id');
    }



    public function has_progress()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasMany(UserTrainingTiltle::class, 'title_id', 'id')
//            ->where('content_id', '>', 0)
            ->whereIn('content_id', function ($query) {
                $query->select('id')
                    ->from(with(new TitleContent())->getTable());
//                    ->where('title_id', '=', 'training_titles.id');
            })
            ->where('user_id', $user_id);
    }

    public function emp_categories()
    {
        return $this->belongsToMany(EmployeeCategory::class, Category_Training::class, 'training_id', 'category_id', 'id', 'id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'section_trainings', 'training_id', 'department_id');
    }

    public function result()
    {
        return $this->hasOne(Result::class, 'training_id', 'id')->where('user_id', auth()->id());
    }


    public function is_register()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(UserTraining::class, 'training_id', 'id')
            ->where('user_id', $user_id);
    }

    public function is_like()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(Like::class, 'liked_id', 'id')
            ->where('type', 'training')
            ->where('user_id', $user_id);
    }



    public function user_titile()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasMany(TrainingTitle::class, 'training_id', 'id')
            ->whereIn('id', function ($query) use ($user_id) {
                $query->select('title_id')
                    ->from(with(new UserTrainingTiltle())->getTable())
                    ->where('user_id', $user_id)
                    ->where('content_id', 0);
            });
    }

    public function begin_training()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasMany(TrainingTitle::class, 'training_id', 'id')
            ->whereIn('id', function ($query) use ($user_id) {
                $query->select('title_id')
                    ->from(with(new UserTrainingTiltle())->getTable())
                    ->where('user_id', $user_id);
            });
    }

}
