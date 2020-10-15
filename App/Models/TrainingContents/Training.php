<?php

namespace App\Models\TrainingContents;

use App\Category_Training;
use App\Department;
use App\EmployeeCategory;
use App\Exam;
use App\Like;
use App\Models\Rateable\Rateable;
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


    protected $appends = ['published', 'can_register', 'average_rating', 'count_rating', 'percent_rating'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    function getAverageRatingAttribute()
    {
        return round($this->averageRating(), 1);
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


    function getCountRatingAttribute()
    {
        return $this->countRating();
    }

    function getPercentRatingAttribute()
    {
        return $this->ratingPercent();
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(SubjectCategory::class, 'category_id', 'id');
    }

    public function titles()
    {
        return $this->hasMany(TrainingTitle::class, 'training_id', 'id');
    }

    public function averageRating()
    {
        return $this->ratings->avg('rating');
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

}
