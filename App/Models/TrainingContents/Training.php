<?php

namespace App\Models\TrainingContents;

use App\Category_Training;
use App\EmployeeCategory;
use App\Exam;
use App\Result;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;

    protected $table = 'trainings';
    protected $guarded = [];

    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
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

    public function titles()
    {
        return $this->hasMany(TrainingTitle::class, 'training_id', 'id');
    }

    public function emp_categories()
    {
        return $this->belongsToMany(EmployeeCategory::class, Category_Training::class, 'training_id', 'category_id', 'id', 'id');
    }

    public function result()
    {
        return $this->hasOne(Result::class, 'training_id', 'id')->where('user_id', auth()->id());
    }
}
