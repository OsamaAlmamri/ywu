<?php

namespace App;

use App\Models\TrainingContents\Training;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserTraining extends Model
{
    //
    protected $table = 'user_trainings';
    protected $fillable = ['training_id', 'user_id', 'status'];


    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
