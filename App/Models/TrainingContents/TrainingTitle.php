<?php

namespace App\Models\TrainingContents;

use App\UserTrainingTiltle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingTitle extends Model
{
    use SoftDeletes;

    protected $table = 'training_titles';
    protected $guarded = [];

    protected $appends = ['published','is_complete'];

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

    function getIsCompleteAttribute()
    {
        $complete = $this->user_contents()->count();
        $titles = $this->contents()->count();
//        return $complete;
        return ($complete >= $titles);

    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(TitleContent::class, 'title_id', 'id');
    }

    public function user_contents()
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

//    public function is_complete()
//    {
//        return $this->hasOne(UserTrainingTiltle::class, 'title_id', 'id')->where('user_id', auth()->id());
//    }
}
