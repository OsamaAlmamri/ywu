<?php

namespace App\Models\TrainingContents;

use App\UserTrainingTiltle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TitleContent extends Model
{
    use SoftDeletes;

    protected $table = 'title_contents';
    protected $guarded = [];

    protected $appends = ['published','is_complete'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    function getIsCompleteAttribute()
    {
        $complete = $this->user_content()->count();

        return ($complete>0);

    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function title_C()
    {
        return $this->belongsTo(TrainingTitle::class, 'title_id', 'id');
    }

    public function user_content()
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;

        return $this->hasOne(UserTrainingTiltle::class, 'content_id', 'id')
            ->where('user_id',$user_id);
    }


}
