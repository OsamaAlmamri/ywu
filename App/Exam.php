<?php

namespace App;

use App\Models\TrainingContents\Training;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
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

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'exam_id', 'id');
    }
}
