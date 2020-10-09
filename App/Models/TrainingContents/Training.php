<?php

namespace App\Models\TrainingContents;

use App\Category_Training;
use App\Department;
use App\EmployeeCategory;
use App\Exam;
use App\Models\Rateable\Rateable;
use App\Result;
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




    protected $appends = ['published','average-rating','count-rating','percent-rating'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    function getAverageRatingAttribute(){
        return round($this->averageRating(),1);
    }

    function getCountRatingAttribute(){
        return $this->countRating();
    }
    function getPercentRatingAttribute(){
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
        $user_id= (auth()->guard('api')->user())?auth()->guard('api')->user()->id:0;
            return $this->hasOne(UserTraining::class, 'training_id', 'id')
            ->where('user_id', $user_id);
    }
}
