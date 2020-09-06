<?php

namespace App\Models\TrainingContents;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TitleContent extends Model
{
    use SoftDeletes;

    protected $table = 'title_contents';
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

    public function title_C()
    {
        return $this->belongsTo(TrainingTitle::class, 'title_id', 'id');
    }
}
