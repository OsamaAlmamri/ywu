<?php

namespace App\Models\TrainingContents;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'subjects';
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
    ];

    public function category()
    {
        return $this->belongsTo(SubjectCategory::class, 'category_id', 'id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'subject_id', 'id');
    }
}
