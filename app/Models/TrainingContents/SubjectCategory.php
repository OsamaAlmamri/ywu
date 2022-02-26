<?php

namespace App\Models\TrainingContents;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SubjectCategory extends Model
{
    protected $table = 'subject_categories';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'category_id', 'id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'category_id', 'id');
    }
}
